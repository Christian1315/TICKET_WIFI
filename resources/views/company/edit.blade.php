<x-app-layout>
    <x-slot name="title">Isp</x-slot>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('success'))
                    <div class="alert alert-success text-gray-400">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        <i class="bi bi-pencil"></i> &nbsp; {{ __('Fournisseur d\'Accès Internet (FAI)') }}
                    </h2>

                    <form method="post" action="{{ route('company.update', $company ? $company->id : null) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Info -->
                        <div class="alert alert-warning border-left border-bold">
                            <i class="bi bi-info-circle"></i> Les champs portant le signe (<span class="text-danger">*</span>) sont réquis!
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ __('FAI') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">{{ __("Modifier les Informatrions de votre FAI") }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <x-input-label for="name" value="{{ __('Fai name') }}" class="mt-4"> <span class="text-danger">*</span> </x-input-label>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $company ? $company->name : '') }}" required placeholder="Ex: Pay Wifi"></x-text-input>

                                    @error("name")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <x-input-label for="address" value="{{ __('Address') }}" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" value="{{ old('address', $company ? $company->address : '') }}" required placeholder="Ex: Cotonou | Rue 229"></x-text-input>
                                    
                                    @error("address")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <x-input-label for="email" value="{{ __('Adresse mail') }}" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" value="{{ old('email', $company ? $company->email : '') }}" required placeholder="Ex: paywifi@gmail.com"></x-text-input>
                                    @error("email")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <x-input-label for="phone" value="{{ __('Phone number') }}" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" value="{{ old('phone', $company ? $company->phone : '') }}" required placeholder="Ex: +2290187653467"></x-text-input>
                                    @error("phone")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-content-center items-center gap-4 mt-4">
                            <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                <i class="bi bi-check-circle"></i> &nbsp; {{ __('Enregistrer') }}
                            </button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>