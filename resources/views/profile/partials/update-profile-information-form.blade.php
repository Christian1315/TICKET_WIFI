<section>
    <header class="text-center">
        <h4 class="d-flex justify-content-center">
            <img src="{{$user->profile??asset('images/bg1.png')}}" alt="Image de profile" class="profil-img img-fluid shadow">
        </h4>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Information génerales') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Mettez à jour les informations de profil et l'adresse électronique de votre compte.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Nom & Prénom')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse électronique.') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="profile" :value="__('Photo de profile')" />
                    <x-text-input id="profile" name="profile" type="file" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('profile')" />
                </div>
                <div class="mb-3">
                    <x-input-label for="phone" :value="__('Téléphone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" placeholder="+22967564534" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-4">
            <div class="">
                <x-primary-button class="w-100 bg-blue btn-hover"><i class="bi bi-check2-circle"></i> &nbsp; {{ __('Enregistrer') }}</x-primary-button>
            </div>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Modifié.') }}</p>
            @endif
        </div>
    </form>
</section>