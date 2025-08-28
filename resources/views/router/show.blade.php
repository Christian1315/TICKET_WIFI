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

                                    <div id="map" style="height: 500px; width: 100%;"></div>

                                    <input type="text" name="map_lat" id="latitude" value="{{$router->map_lat}}">
                                    <input type="text" name="map_long" id="longitude" value="{{$router->map_long}}">
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("styles")
    <!-- CSS Leaflet et Leaflet Draw -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    @endpush

    @push('scripts')
    <!-- JS Leaflet et Leaflet Draw -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Récupérer les coordonnées du router depuis tes inputs
            const latInput = document.getElementById("latitude");
            const lngInput = document.getElementById("longitude");
            const latVal = parseFloat(latInput.value);
            const lngVal = parseFloat(lngInput.value);

            // Centrer la carte sur le router si les coordonnées existent
            const map = L.map('map').setView(
                latVal && lngVal ? [latVal, lngVal] : [6.370293, 2.391236],
                latVal && lngVal ? 13 : 10
            );

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            // Si le router a déjà des coordonnées, ajouter un marqueur
            if (latVal && lngVal) {
                const marker = L.marker([latVal, lngVal]).addTo(drawnItems);
                marker.bindPopup("Emplacement actuel du router ({{$router->name}})").openPopup();
            }

            const drawControl = new L.Control.Draw({
                draw: {
                    polygon: true,
                    rectangle: true,
                    circle: true,
                    marker: false,
                    polyline: false,
                    circlemarker: false
                },
                edit: {
                    featureGroup: drawnItems
                }
            });
            // map.addControl(drawControl);

            // Dessiner une zone
            map.on(L.Draw.Event.CREATED, function(e) {
                const layer = e.layer;

                drawnItems.clearLayers(); // Supprimer l’ancienne zone
                drawnItems.addLayer(layer);

                let lat = null;
                let lng = null;

                if (layer instanceof L.Polygon || layer instanceof L.Rectangle) {
                    const bounds = layer.getBounds();
                    lat = bounds.getCenter().lat;
                    lng = bounds.getCenter().lng;
                } else if (layer instanceof L.Circle) {
                    const center = layer.getLatLng();
                    lat = center.lat;
                    lng = center.lng;
                }

                latInput.value = lat;
                lngInput.value = lng;

                console.log("Latitude :", lat, "Longitude :", lng);
            });

        });
    </script>
    @endpush
</x-app-layout>