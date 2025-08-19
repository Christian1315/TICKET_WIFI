<x-app-layout>
    <x-slot name="title">Créer un router</x-slot>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h2 class="d-flex justify-content font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        <i class="bi bi-node-plus"></i> &nbsp;{{ __('Ajouter un router') }}
                    </h2>

                    <!-- Retour sur liste -->
                    <div class="flex justify-content-center">
                        <a href="{{route('router.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                            <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                        </a>
                    </div>

                    <!-- Formulaire d'ajout -->
                    <form method="post" action="{{ route('router.store') }}" class="space-y-6">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Nom du router')"></x-input-label>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="Router 1" required></x-text-input>

                                    @error("name")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <x-input-label for="location" :value="__('Emplacement')" class="mt-4"></x-input-label>
                                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')"  placeholder="Zone 1"></x-text-input>

                                    @error("location")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="ip" :value="__('Adresse IP')" class=""></x-input-label>
                                    <x-text-input id="ip" name="ip" type="text" class="mt-1 block w-full" :value="old('ip')" required placeholder="192.168.1.1"></x-text-input>

                                    @error("ip")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <x-input-label for="username" :value="__('Identifiant du router')" class="mt-4"></x-input-label>
                                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required placeholder="username1"></x-text-input>

                                    @error("username")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Mot de passe du router')" class="mt-4"></x-input-label>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :value="old('password')" required placeholder="*********"></x-text-input>

                                @error("password")
                                <span class="text-orange">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-content-center items-center gap-4 mt-4">
                            <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                <i class="bi bi-check-circle"></i> &nbsp; {{ __('Enregistrer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>