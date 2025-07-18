<x-guest-layout>
    <x-slot name="title">Créer un compte</x-slot>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-text-input id="name" class="block mt-1 w-full" type="text" placeholder="Nom & Prénom" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                placeholder="Mot de passe"
                :value="old('password')"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                placeholder="Confirmer mot de passe"
                :value="old('password_confirmation')"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="block d-flex items-center justify-content-between mt-4">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Avez-vous déjà un compte?') }}
            </a>
        </div>

        <div class="mt-3">
            <button type="submit" class="w-100 btn btn-sm bg-blue btn-hover text-white"><i class="bi bi-check2-circle"></i> {{ __('Enregistrer') }}</button>
        </div>
    </form>
</x-guest-layout>