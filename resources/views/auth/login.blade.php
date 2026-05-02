<x-guest-layout>
    <h4 class="auth-title">Masuk ke Akun</h4>
    <p class="auth-sub">Selamat datang kembali 👋</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="email@kamu.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label class="inline-flex" style="font-weight: 400; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember"
                       style="width:auto; margin-right: 6px;">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="ms-3">
                Masuk
            </button>
        </div>

        <hr style="margin: 1.5rem 0; border-color: #F3F4F6;">

        <p class="text-center text-sm text-gray-600" style="margin: 0;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color: #FBB917; font-weight: 600; text-decoration: none;">
                Daftar sekarang
            </a>
        </p>
    </form>
</x-guest-layout>
