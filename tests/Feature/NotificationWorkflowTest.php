<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skill;
use App\Notifications\CompleteProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a user skipping onboarding gets profile completion reminder.
     */
    public function test_user_skipping_onboarding_gets_profile_completion_reminder(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'New User',
            'email' => 'new.user@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'onboarding_completed' => false,
        ]);

        $response = $this->actingAs($user)
            ->post(route('onboarding.skip'));

        $response->assertRedirect(route('feed.index'));

        Notification::assertSentTo($user, CompleteProfile::class);
    }

    /**
     * Test a user completing onboarding with skills gets profile completion reminder if bio is empty.
     */
    public function test_user_completing_onboarding_without_bio_gets_profile_completion_reminder(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'New User',
            'email' => 'new.user@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'onboarding_completed' => false,
        ]);

        $skill1 = Skill::create(['name' => 'Skill 1']);
        $skill2 = Skill::create(['name' => 'Skill 2']);
        $skill3 = Skill::create(['name' => 'Skill 3']);

        $response = $this->actingAs($user)
            ->post(route('onboarding.save-skills'), [
                'skills' => [$skill1->id, $skill2->id, $skill3->id],
            ]);

        $response->assertRedirect(route('feed.index'));

        // Sent because bio is still empty
        Notification::assertSentTo($user, CompleteProfile::class);
    }

    /**
     * Test a user completing onboarding with skills and bio does not get reminder.
     */
    public function test_user_with_complete_profile_does_not_get_reminder(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'New User',
            'email' => 'new.user@bsi.ac.id',
            'password' => Hash::make('password123'),
            'is_verified' => true,
            'onboarding_completed' => false,
            'bio' => 'My bio here',
        ]);

        $skill1 = Skill::create(['name' => 'Skill 1']);
        $skill2 = Skill::create(['name' => 'Skill 2']);
        $skill3 = Skill::create(['name' => 'Skill 3']);

        $response = $this->actingAs($user)
            ->post(route('onboarding.save-skills'), [
                'skills' => [$skill1->id, $skill2->id, $skill3->id],
            ]);

        $response->assertRedirect(route('feed.index'));

        Notification::assertNotSentTo($user, CompleteProfile::class);
    }
}
