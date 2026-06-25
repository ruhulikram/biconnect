@props([
    'name'     => 'code',
    'digits'   => 6,
    'email'    => null,
    'error'    => null,
    'countdown'=> 45,
])

<div x-data="otpInput({{ $digits }}, {{ $countdown }})" class="space-y-5">
    {{-- Hidden input to submit the full OTP code --}}
    <input type="hidden" name="{{ $name }}" :value="digits.join('')">

    {{-- OTP boxes --}}
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
                :class="{
                    'border-primary shadow-focus': digits[index] !== '',
                    'border-red-500': hasError
                }"
                class="w-11 h-14 text-center text-lg font-semibold font-heading text-gray-900 bg-white border border-border rounded-input
                       focus:outline-none focus:border-primary focus:shadow-focus transition-all duration-150
                       dark:bg-gray-800 dark:text-white dark:border-gray-700">
        </template>
    </div>

    {{-- Error message --}}
    @if($error)
        <p class="text-xs text-red-500 text-center flex items-center justify-center gap-1">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            </svg>
            {{ $error }}
        </p>
    @endif

    {{-- Submit button (optional - can be placed outside via slot) --}}
    <button
        type="submit"
        :disabled="!isComplete"
        class="w-full h-12 rounded-input bg-primary text-white text-sm font-medium transition-colors duration-150
               hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary/20
               disabled:opacity-40 disabled:cursor-not-allowed">
        Verifikasi
    </button>

    {{-- Resend countdown --}}
    <div class="text-center text-sm">
        <template x-if="countdown > 0">
            <p class="text-gray-400 dark:text-gray-500">
                Kirim ulang dalam <span class="font-medium text-gray-600 dark:text-gray-400" x-text="formatCountdown()"></span>
            </p>
        </template>
        <template x-if="countdown <= 0">
            {{ $resend ?? '' }}
        </template>
    </div>
</div>

@push('scripts')
<script>
function otpInput(totalDigits = 6, initialCountdown = 45) {
    return {
        digits: Array(totalDigits).fill(''),
        countdown: initialCountdown,
        hasError: false,
        timer: null,

        get isComplete() {
            return this.digits.every(d => d !== '');
        },

        init() {
            // Focus first input on mount
            this.$nextTick(() => {
                const inputs = this.$refs.otpInput;
                if (inputs && inputs[0]) inputs[0].focus();
            });

            // Start countdown
            this.timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) clearInterval(this.timer);
            }, 1000);
        },

        formatCountdown() {
            const mins = Math.floor(this.countdown / 60);
            const secs = this.countdown % 60;
            if (mins > 0) {
                return `${mins}:${String(secs).padStart(2, '0')}`;
            }
            return `${secs}s`;
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
            if (index < totalDigits - 1) {
                const inputs = this.$refs.otpInput;
                if (inputs[index + 1]) inputs[index + 1].focus();
            }

            // Dispatch event when complete (parent can listen and auto-submit)
            if (this.isComplete) {
                this.$dispatch('otp-complete', { code: this.digits.join('') });
            }
        },

        handleBackspace(index, event) {
            if (this.digits[index] === '' && index > 0) {
                const inputs = this.$refs.otpInput;
                if (inputs[index - 1]) {
                    inputs[index - 1].focus();
                    this.digits[index - 1] = '';
                }
                event.preventDefault();
            }
        },

        handlePaste(event) {
            const pasted = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, totalDigits);
            for (let i = 0; i < totalDigits; i++) {
                this.digits[i] = pasted[i] || '';
            }
            this.hasError = false;

            // Focus last filled input
            const inputs = this.$refs.otpInput;
            const focusIndex = Math.min(pasted.length, totalDigits - 1);
            if (inputs[focusIndex]) inputs[focusIndex].focus();

            // Dispatch if fully pasted
            if (pasted.length === totalDigits) {
                this.$dispatch('otp-complete', { code: this.digits.join('') });
            }
        }
    };
}
</script>
@endpush
