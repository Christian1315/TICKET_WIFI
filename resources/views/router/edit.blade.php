<x-app-layout>
    <x-slot name="title">Modifier</x-slot>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Edit Router') }}
                    </h2>

                    <form method="post" action="{{ route('router.update', $router->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <x-input-label for="name" :value="__('Nom du router')"></x-input-label>
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')??$router->name" placeholder="Router 1" required></x-text-input>

                                        @error("name")
                                        <span class="text-orange">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <x-input-label for="location" :value="__('Emplacement')" class=""></x-input-label>
                                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')??$router->location" placeholder="Zone 1"></x-text-input>

                                        @error("location")
                                        <span class="text-orange">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <x-input-label for="ip" :value="__('Adresse IP')" class=""></x-input-label>
                                        <x-text-input id="ip" name="ip" type="text" class="mt-1 block w-full" :value="old('ip')??$router->ip" required placeholder="192.168.1.1"></x-text-input>

                                        @error("ip")
                                        <span class="text-orange">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <x-input-label for="username" :value="__('Identifiant du router')" class=""></x-input-label>
                                        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')??$router->username" required placeholder="username1"></x-text-input>

                                        @error("username")
                                        <span class="text-orange">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <x-input-label for="password" :value="__('Mot de passe du router')" class="mt-4"></x-input-label>
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :value="old('password')??$router->password" required placeholder="*********"></x-text-input>

                                        @error("password")
                                        <span class="text-orange">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="flex justify-content-center items-center gap-4 mt-4">
                                <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                    <i class="bi bi-check-circle"></i> &nbsp; {{ __('Modifier') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>