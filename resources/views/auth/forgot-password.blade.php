<x-guest-layout>
    <x-slot name="title">Mot de passe oublié</x-slot>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse électronique et nous vous redirigerons sur une page de changement de mot de passe') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-sm w-100 bg-blue btn-hover text-white"><i class="bi bi-person-lock"></i> {{ __('Récuperer mon mot de passe') }}</button>
        </div>
    </form>
</x-guest-layout>