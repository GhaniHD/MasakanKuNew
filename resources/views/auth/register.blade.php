<x-guest-layout>
    <h4 class="auth-title">Buat Akun Baru</h4>
    <p class="auth-sub">Bergabung dan mulai berbagi resepmu 🍳</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">Nama</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   placeholder="Nama lengkapmu">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   required autocomplete="username"
                   placeholder="email@kamu.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   placeholder="Min. 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   placeholder="Ulangi password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="ms-4">
                Daftar
            </button>
        </div>
    </form>
</x-guest-layout>
