<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-ink">Welcome back</h1>
        <p class="mt-1.5 text-sm text-slate-500">Sign in to manage orders, payments and reports.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')"
                placeholder="you@example.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-600 hover:text-brand-700"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="relative mt-1.5">
                <x-text-input id="password" class="block w-full pr-16" type="password" name="password"
                    placeholder="••••••••" required autocomplete="current-password" />
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 px-3.5 text-xs font-semibold text-slate-500 hover:text-ink"
                    aria-label="Show password">Show</button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500/30">
            <span class="text-sm text-slate-600">{{ __('Keep me signed in') }}</span>
        </label>

        <x-primary-button class="w-full">
            {{ __('Sign in') }}
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M3 10a.75.75 0 0 1 .75-.75h10.64l-4.22-4.22a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 1 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z"
                    clip-rule="evenodd" />
            </svg>
        </x-primary-button>
    </form>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.textContent = show ? 'Hide' : 'Show';
            this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    </script>
</x-guest-layout>
