@extends('layouts.auth')
@section('title', 'Verifikasi OTP')

@section('content')
<div class="space-y-6" x-data="otpForm()">

    {{-- Logo --}}
    <div class="flex justify-center">
        <img src="{{ asset('images/biconnect-logo.png') }}" alt="BiConnect" class="h-10 w-auto">
    </div>

    {{-- Heading --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold font-heading text-gray-900">Masukkan Kode OTP</h1>
        <p class="text-sm text-gray-500 mt-1.5">
            Kode dikirim ke <span class="font-medium text-gray-700">{{ $email }}</span>
        </p>
    </div>

    {{-- OTP Form --}}
    <form action="{{ route('auth.verify-otp') }}" method="POST" class="space-y-5" x-ref="form">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="code" :value="digits.join('')">

        {{-- 6 OTP boxes --}}
        <div class="flex justify-center gap-2.5">
            <template x-for="(digit, index) in digits" :key="index">
                <input
                    type="text"
                    inputmode="numeric"
                    maxlength="1"
                    x-model="digits[index]"
                    x-ref="otpInput"
                    @input="handleInput(index, $event)"
                    @keydown.backspace="handleBackspace(index, $event)"
                    @paste.prevent="handlePaste($event)"
                    @focus="$event.target.select()"
                    :class="{'border-primary shadow-focus': digits[index] !== '', 'border-red-500': hasError}"
                    class="w-11 h-14 text-center text-lg font-semibold font-heading text-gray-900 bg-white border border-border rounded-input
                           focus:outline-none focus:border-primary focus:shadow-focus transition-all duration-150">
            </template>
        </div>

        {{-- Error --}}
        @if($errors->has('code'))
            <p class="text-xs text-red-500 text-center flex items-center justify-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('code') }}
            </p>
        @endif

        {{-- Submit --}}
        <button
            type="submit"
            :disabled="!isComplete"
            class="w-full h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
                   hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20
                   disabled:opacity-40 disabled:cursor-not-allowed">
            Verifikasi
        </button>
    </form>

    {{-- Resend countdown --}}
    <div class="text-center text-sm">
        <template x-if="countdown > 0">
            <p class="text-gray-400">
                Kirim ulang dalam <span class="font-medium text-gray-600" x-text="countdown + 's'"></span>
            </p>
        </template>
        <template x-if="countdown <= 0">
            <form action="{{ route('auth.send-otp') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-primary font-medium hover:text-primary-dark transition-colors">
                    Kirim ulang kode
                </button>
            </form>
        </template>
    </div>

    {{-- Back link --}}
    <p class="text-center text-sm text-gray-500">
        <a href="{{ route('auth.activate') }}" class="text-primary font-medium hover:text-primary-dark transition-colors">
            ← Ganti email
        </a>
    </p>
</div>
@endsection

@push('scripts')
<script>
function otpForm() {
    return {
        digits: ['', '', '', '', '', ''],
        countdown: 45,
        hasError: {{ $errors->has('code') ? 'true' : 'false' }},

        get isComplete() {
            return this.digits.every(d => d !== '');
        },

        init() {
            // Focus first input
            this.$nextTick(() => {
                const inputs = this.$el.querySelectorAll('input[type="text"]');
                if (inputs && inputs[0]) inputs[0].focus();
            });

            // Start countdown
            const timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) clearInterval(timer);
            }, 1000);
        },

        handleInput(index, event) {
            const value = event.target.value;

            // Only allow digits
            if (!/^\d$/.test(value)) {
                this.digits[index] = '';
                return;
            }

            this.digits[index] = value;
            this.hasError = false;

            // Auto-advance to next input
            if (index < 5) {
                const inputs = event.target.parentElement.querySelectorAll('input[type="text"]');
                if (inputs[index + 1]) inputs[index + 1].focus();
            }

            // Auto-submit when complete
            if (this.isComplete) {
                this.$nextTick(() => this.$refs.form.submit());
            }
        },

        handleBackspace(index, event) {
            if (this.digits[index] === '' && index > 0) {
                const inputs = event.target.parentElement.querySelectorAll('input[type="text"]');
                if (inputs[index - 1]) {
                    inputs[index - 1].focus();
                    this.digits[index - 1] = '';
                }
                event.preventDefault();
            }
        },

        handlePaste(event) {
            const pasted = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            for (let i = 0; i < 6; i++) {
                this.digits[i] = pasted[i] || '';
            }
            this.hasError = false;

            // Focus last filled input
            const inputs = event.target.parentElement.querySelectorAll('input[type="text"]');
            const focusIndex = Math.min(pasted.length, 5);
            if (inputs[focusIndex]) inputs[focusIndex].focus();

            // Auto-submit if fully pasted
            if (pasted.length === 6) {
                this.$nextTick(() => this.$refs.form.submit());
            }
        }
    };
}
</script>
@endpush
