<x-app-layout>
    <x-slot name="title">Packages | Modifier</x-slot>

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
                        <i class="bi bi-node-plus"></i> &nbsp; {{ __('Modifier le package') }}
                    </h2>

                    <!-- Retour sur liste -->
                    <div class="flex justify-content-center">
                        <a href="{{route('packages.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                            <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                        </a>
                    </div>

                    <br>
                    <!-- Formulaire d'ajout -->
                    <form method="post" action="{{ route('packages.update',$package->id) }}" class="space-y-6">
                        @csrf
                        @method("PATCH")
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <x-input-label for="router_id" :value="__('Choix du router')" class=""></x-input-label>
                                    <select name="router_id" value="{{old('router_id')}}" id="router_id" class="block w-full rounded-md border border-gray-300">
                                        <option value="">{{ __('Choississez un router') }}</option>
                                        @foreach ($routers as $router)
                                        <option 
                                        value="{{ $router->id }}"
                                        @selected($package->router_id==$router->id) 
                                        @disabled($router->user_id!=Auth::id())
                                        >{{ $router->name }}</option>
                                        @endforeach
                                    </select>

                                    @error("router_id")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Nom du package')"></x-input-label>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')??$package->name" placeholder="Package 1" required></x-text-input>

                                    @error("name")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <x-input-label for="price" :value="__('Prix du package')"></x-input-label>
                                    <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price')??$package->price" placeholder="800500" required></x-text-input>

                                    @error("price")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description du tarif')"></x-input-label>
                                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description')??$package->description" placeholder="Ex: Tarif standard"></x-text-input>

                                    @error("description")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="validation_time" :value="__('Durée de validité')"> <span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="validation_time" name="validation_time" type="text" class="mt-1 block w-full" :value="old('validation_time')??$package->validation_time" placeholder="Ex: 1H, 2H, 7J" required></x-text-input>

                                    @error("validation_time")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-content-center items-center gap-4 mt-4">
                            <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                <i class="bi bi-pencil"></i> &nbsp; {{ __('Modifier') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>