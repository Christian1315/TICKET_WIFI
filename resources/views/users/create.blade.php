<x-app-layout>
    <x-slot name="title">Créer un utilisateur</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        <i class="bi bi-node-plus"></i> &nbsp; {{ __('Ajouter un utilisateur') }}
                    </h2>

                    <form method="post" action="{{ route('users.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Info -->
                        <div class="alert alert-warning border-left border-bold">
                            <i class="bi bi-info-circle"></i> Les champs portant le signe (<span class="text-danger">*</span>) sont réquis!
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100"><i class="bi bi-person-add"></i> {{ __('Utilisateur') }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Détails d'ajout des utilisateurs") }}</p>
                        </div>

                        <!-- Retour sur liste -->
                        <div class="flex justify-content-center">
                            <a href="{{route('users.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                                <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <x-input-label for="name" :value="__('Nom & Prénom')" class="mt-4"> <span class="text-danger">*</span> </x-input-label>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Ex: Joe"></x-text-input>
                                @error("name")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="email" :value="__('Adresse mail')" class="mt-4"><span class="text-danger">*</span> </x-input-label>
                                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email')" required placeholder="Ex: joe@gmail.com"></x-text-input>
                                @error("email")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="password" :value="__('Mot de passe')" class="mt-4"><span class="text-danger">*</span> </x-input-label>
                                <x-text-input name="password" type="password" class="mt-1 block w-full" :value="old('password')" required placeholder="*****"></x-text-input>
                                @error("password")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full" :value="old('password_confirmation')" required placeholder="*****"></x-text-input>
                                @error("password_confirmation")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="address" :value="__('Address')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required placeholder="Ex: Cotonou | Rue 229"></x-text-input>
                                @error("address")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="phone" :value="__('Numéro de téléphone')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone')" required placeholder="Ex : +2290156789067"></x-text-input>
                                @error("phone")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="dob" :value="__('Date of birth')" class="mt-4"> <span class="text-danger">*</span></x-input-label>
                                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob')" required></x-text-input>
                                @error("phone")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <x-input-label for="pin" :value="__('Numéro Personnel d\'Identification')" class="mt-4"> <span class="text-danger">*</span></x-input-label>
                                <x-text-input id="pin" name="pin" type="text" class="mt-1 block w-full" :value="old('pin')" required placeholder="00456789"></x-text-input>
                                @error("pin")
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100"><i class="bi bi-box-arrow-right"></i> {{ __('Souscription') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Détails de souscription") }}</p>
                            </div>

                            <div class="mt-4">
                                <div class="mb-3">
                                    <x-input-label for="router_id" :value="__('Choix du router')" class=""> <span class="text-danger">*</span> </x-input-label>
                                    <select name="router_id" value="{{old('router_id')}}" id="router_id" required class="block w-full rounded-md border border-gray-300">
                                        <option value="">{{ __('Choisissez un router') }}</option>
                                        @foreach ($routers as $router)
                                        <option
                                            value="{{ $router->id }}"
                                            data-packages="{{$router->packages}}"
                                            @selected($router->id==old('router_id'))>{{ $router->name }}</option>
                                        @endforeach
                                    </select>

                                    @error("router_id")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <x-input-label for="package_id" :value="__('Choix du tarif(package)')" class=""> <span class="text-danger">*</span> </x-input-label>
                                    <select name="package_id" value="{{old('package_id')}}" id="package_id" required class="block w-full rounded-md border border-gray-300">
                                        <!-- js -->
                                    </select>

                                    @error("package_id")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex justify-content-center items-center gap-4 mt-4">
                                    <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                        <i class="bi bi-check-circle"></i> &nbsp; {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("scripts")
    <script>
        $(document).ready(function() {
            $("#router_id").on("select2:select", function(e) {

                const selected = $(this).find(':selected');
                const packages = selected.data("packages");

                let rows = `<option value="">{{ __('Choisissez un package') }}</option>`

                $("#package_id").html('')

                if (packages.length > 0) {
                    packages.forEach(package => {
                        rows += `<option value="${package.id}">${package.name}</option>`
                    });
                }

                $("#package_id").html(rows)
            })
        })
    </script>
    @endpush
</x-app-layout>