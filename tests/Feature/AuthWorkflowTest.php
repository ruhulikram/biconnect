<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\OtpVerification;
use App\Notifications\ResetPasswordNotification;
use App\Mail\EmailVerificationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test verified user cannot request activation OTP (Prevents Account Hijack).
     */
    public function test_verified_user_cannot_request_activation_otp(): void
    {
        $user = User::create([
            'name' => 'Active User',
            'email' => 'active.user@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'onboarding_completed' => true,
        ]);

        $response = $this->post(route('auth.send-otp'), [
            'email' => 'active.user@bsi.ac.id',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(0, OtpVerification::count());
    }

    /**
     * Test unverified login redirect (UX improvement).
     */
    public function test_unverified_login_redirects_to_verification_notice(): void
    {
        $user = User::create([
            'name' => 'Unverified User',
            'email' => 'unverified.user@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => false,
            'onboarding_completed' => true,
        ]);

        $response = $this->post(route('auth.do-login'), [
            'email' => 'unverified.user@bsi.ac.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $response->assertSessionHas('warning');
        $this->assertFalse(auth()->check());
    }

    /**
     * Test password reset notification uses Indonesian content.
     */
    public function test_password_reset_sends_indonesian_notification(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'Ikram Maulana',
            'email' => 'ikram.maulana@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'onboarding_completed' => true,
        ]);

        $this->post(route('password.email'), [
            'email' => 'ikram.maulana@bsi.ac.id',
        ]);

        Notification::assertSentTo(
            $user,
            ResetPasswordNotification::class,
            function ($notification, $channels) use ($user) {
                $mailMessage = $notification->toMail($user);
                $this->assertEquals('Reset Password — BiConnect', $mailMessage->subject);
                $this->assertStringContainsString('Kamu menerima email ini karena kami menerima permintaan reset password', $mailMessage->introLines[0]);
                return true;
            }
        );
    }

    /**
     * Test admin dashboard accessibility and navigation toggles.
     */
    public function test_admin_dashboard_access_and_navbar_toggle(): void
    {
        $admin = User::create([
            'name' => 'Admin BSI',
            'email' => 'admin@biconnect.bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_admin' => true,
            'is_verified' => true,
            'onboarding_completed' => true,
        ]);

        $regular = User::create([
            'name' => 'Regular User',
            'email' => 'regular@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_admin' => false,
            'is_verified' => true,
            'onboarding_completed' => true,
        ]);

        // Regular user cannot access admin dashboard
        $this->actingAs($regular);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // Admin user can access admin dashboard
        $this->actingAs($admin);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        
        // Admin dashboard sidebar should contain "Kembali ke Feed" link
        $response->assertSee('Kembali ke Feed');
        $response->assertSee(route('feed.index'));

        // Admin rendering navbar has link to dashboard admin
        $response = $this->get(route('feed.index'));
        $response->assertSee('Dashboard Admin');
        $response->assertSee(route('admin.dashboard'));

        // Regular user rendering navbar does NOT have link to dashboard admin
        $this->actingAs($regular);
        $response = $this->get(route('feed.index'));
        $response->assertDontSee('Dashboard Admin');
        $response->assertDontSee(route('admin.dashboard'));
    }

    /**
     * Test OTP verification success.
     */
    public function test_verify_otp_success(): void
    {
        Mail::fake();
        $email = 'new.student@bsi.ac.id';

        // 1. Request OTP
        $response = $this->post(route('auth.send-otp'), [
            'email' => $email,
        ]);

        $response->assertRedirect(route('auth.otp'));
        $this->assertEquals($email, session('otp_email'));

        // Retrieve the generated OTP from DB
        $otp = OtpVerification::where('email', $email)->latest('created_at')->first();
        $this->assertNotNull($otp);

        // 2. Verify OTP
        $response = $this->post(route('auth.verify-otp'), [
            'email' => $email,
            'code' => $otp->code,
        ]);

        $response->assertRedirect(route('auth.create-password'));
        $this->assertNotNull(session('verified_user_id'));

        // Refresh and check it is marked as used
        $otp->refresh();
        $this->assertNotNull($otp->used_at);
    }

    /**
     * Test OTP verification fails with invalid code.
     */
    public function test_verify_otp_invalid_code(): void
    {
        $email = 'new.student@bsi.ac.id';

        OtpVerification::create([
            'email' => $email,
            'code' => '123456',
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->post(route('auth.verify-otp'), [
            'email' => $email,
            'code' => '654321', // wrong code
        ]);

        $response->assertSessionHasErrors(['code']);
        $response->assertSessionHasErrors(['code' => 'Kode OTP tidak valid.']);
    }

    /**
     * Test OTP verification fails with expired code.
     */
    public function test_verify_otp_expired_code(): void
    {
        $email = 'new.student@bsi.ac.id';
        $code = '123456';

        // Create expired OTP (1 minute ago)
        OtpVerification::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->subMinute(),
        ]);

        $response = $this->post(route('auth.verify-otp'), [
            'email' => $email,
            'code' => $code,
        ]);

        $response->assertSessionHasErrors(['code']);
        $response->assertSessionHasErrors(['code' => 'Kode OTP sudah kedaluwarsa.']);
    }
}
