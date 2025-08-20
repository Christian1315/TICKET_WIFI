<x-app-layout>
    <x-slot name="title">Router | Détail</x-slot>
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
                        <i class="bi bi-eye"></i> &nbsp; {{ __('Voir détail Router') }}
                    </h2>

                    <!-- Retour sur liste -->
                    <div class="flex justify-content-center">
                        <a href="{{route('router.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                            <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                        </a>
                    </div>

                    <br>
                    <form class="mt-6 space-y-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Nom du router')"><span class="text-danger">*</span> </x-input-label>
                                    <x-text-input id="name" readonly name="name" type="text" class="mt-1 block w-full" :value="old('name')??$router->name" placeholder="Router 1" required></x-text-input>

                                </div>
                                <div class="mb-3">
                                    <x-input-label for="location" :value="__('Emplacement')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="location" readonly name="location" type="text" class="mt-1 block w-full" :value="old('location')??$router->location" placeholder="Zone 1"></x-text-input>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="ip" :value="__('Adresse IP')" class=""><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="ip" name="ip" readonly type="text" class="mt-1 block w-full" :value="old('ip')??$router->ip" required placeholder="192.168.1.1"></x-text-input>

                                </div>
                                <div class="mb-3">
                                    <x-input-label for="username" :value="__('Identifiant du router')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="username" readonly name="username" type="text" class="mt-1 block w-full" :value="old('username')??$router->username" required placeholder="username1"></x-text-input>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="password" :value="__('Mot de passe du router')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="password" readonly name="password" type="password" class="mt-1 block w-full" :value="old('password')??$router->password" required placeholder="*********"></x-text-input>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="contact" :value="__('Contact whatsapp du client')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="contact" readonly name="contact" type="tel" class="mt-1 block w-full" :value="old('contact')??$router->contact" required placeholder="+2290156453423"></x-text-input>
                                   
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="type" :value="__('Type de router')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="type" readonly name="type" class="mt-1 block w-full" :value="old('type')??$router->type"></x-text-input>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" class="mt-4"></x-input-label>
                                    <x-text-input id="description" readonly name="description" type="text" class="mt-1 block w-full" :value="old('description')??$router->description" placeholder="Wifi haute vitesse situé au centre ville"></x-text-input>
                                </div>
                            </div>

                            @if($router->map_long || $router->map_lat)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="map" :value="__('Emplacement de la zone sur le map')" class="mt-4"><span class="text-danger"><i class="bi bi-geo-alt-fill"></i></span></x-input-label>

                                    <x-maps-leaflet
                                        :zoomLevel="4"
                                        :center="['lat' => $router->map_lat, 'lng' => $router->map_long]"
                                        :markers="[['lat' => $router->map_lat, 'long' => $router->map_long]]"
                                        :options="['scrollWheelZoom' => true, 'dragging' => true]"></x-maps-leaflet>
                                    <input type="hidden" name="map_lat" id="latitude" value="{{$router->map_lat}}">
                                    <input type="hidden" name="map_long" id="longitude" value="{{$router->map_long}}">
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("scripts")
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialisation avec coordonnées du router ou par défaut
            let lat = {
                {
                    $router - > map_lat ?? 0
                }
            };
            let lng = {
                {
                    $router - > map_long ?? 0
                }
            };

            let map = L.map('map').setView([lat, lng], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            // Afficher un marker existant si dispo
            let marker = L.marker([lat, lng]).addTo(map);

            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Déplacer ou créer le marker
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>