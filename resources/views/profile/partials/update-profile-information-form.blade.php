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

    <form method="post" action="{{ route('users.update',Auth::id()) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- <div class="row">
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
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-input-label for="profile" :value="__('Photo de profile')" />
                    <x-text-input id="profile" name="profile" type="file" class="mt-1 block w-full" />
                    @error("profile")
                    <span class="text-orange"></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <x-input-label for="phone" :value="__('Téléphone')" />
                    <x-text-input id="phone" name="phone" type="text" :value="old('phone',$user->phone)" class="mt-1 block w-full" placeholder="+22967564534" />

                    @error("phone")
                    <span class="text-orange"></span>
                    @enderror
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-4">
                <x-input-label for="name" :value="__('Nom & Prénom')" class="mt-4"> <span class="text-danger">*</span> </x-input-label>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name',$user->name)" required placeholder="Ex: Joe"></x-text-input>
                @error("name")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <x-input-label for="email" :value="__('Adresse mail')" class="mt-4"><span class="text-danger">*</span> </x-input-label>
                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email',$user->email)" required placeholder="Ex: joe@gmail.com"></x-text-input>
                @error("email")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <x-input-label for="address" :value="__('Address')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address',$user->detail?->address)" required placeholder="Ex: Cotonou | Rue 229"></x-text-input>
                @error("address")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <x-input-label for="phone" :value="__('Numéro de téléphone')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone',$user->detail?->phone)" required placeholder="Ex : +2290156789067"></x-text-input>
                @error("phone")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <x-input-label for="dob" :value="__('Date of birth')" class="mt-4"> <span class="text-danger">*</span></x-input-label>
                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob',$user->detail?->dob)" required></x-text-input>
                @error("phone")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <x-input-label for="pin" :value="__('Numéro Personnel d\'Identification')" class="mt-4"> <span class="text-danger">*</span></x-input-label>
                <x-text-input id="pin" name="pin" type="text" class="mt-1 block w-full" :value="old('pin',$user->detail?->pin)" required placeholder="00456789"></x-text-input>
                @error("pin")
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <x-input-label for="kkiapay_key" :value="__('Votre clé Api KKiapay')"> </x-input-label>
                    <x-text-input id="kkiapay_key" name="kkiapay_key" :value="old('kkiapay_key',$user->detail?->kkiapay_key)" type="text" class="mt-1 block w-full" placeholder="f062d0c0666553311ef8a1de375275411b5" />
                    @error("kkiapay_key")
                    <span class="text-orange"></span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <x-input-label for="stripe_key" :value="__('Votre clé Api Stripe')"> </x-input-label>
                    <x-text-input id="stripe_key" name="stripe_key" :value="old('stripe_key',$user->detail?->stripe_key)" type="text" class="mt-1 block w-full" placeholder="f062d0c0666553311ef8a1de375275411b5" />
                    @error("stripe_key")
                    <span class="text-orange"></span>
                    @enderror
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