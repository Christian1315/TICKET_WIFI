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

                        <!-- Info -->
                        <div class="alert alert-warning border-left border-bold">
                            <i class="bi bi-info-circle"></i> Les champs portant le signe (<span class="text-danger">*</span>) sont réquis!
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Nom du router')"><span class="text-danger">*</span> </x-input-label>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="Router 1" required></x-text-input>

                                    @error("name")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <x-input-label for="location" :value="__('Emplacement')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" placeholder="Zone 1"></x-text-input>

                                    @error("location")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="ip" :value="__('Adresse IP')" class=""><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="ip" name="ip" type="text" class="mt-1 block w-full" :value="old('ip')" required placeholder="192.168.1.1"></x-text-input>

                                    @error("ip")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <x-input-label for="username" :value="__('Identifiant du router')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required placeholder="username1"></x-text-input>

                                    @error("username")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="password" :value="__('Mot de passe du router')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :value="old('password')" required placeholder="*********"></x-text-input>

                                    @error("password")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="contact" :value="__('Contact whatsapp du client')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                    <x-text-input id="contact" name="contact" type="tel" class="mt-1 block w-full" :value="old('contact')" required placeholder="+2290156453423"></x-text-input>

                                    @error("contact")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="type" :value="__('Type de router')" class="mt-4"><span class="text-danger">*</span></x-input-label>

                                    <select name="type" id="type" class="form-control">
                                        <option @selected(old('type')=='Mikrotik' ) value="Mikrotik">Mikrotik</option>
                                        <option @selected(old('type')=='PfSence' ) value="PfSence">PfSence</option>
                                        <option @selected(old('type')=='Omada' ) value="Omada">Omada</option>
                                    </select>
                                    @error("type")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" class="mt-4"></x-input-label>
                                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description')" placeholder="Wifi haute vitesse situé au centre ville"></x-text-input>

                                    @error("description")
                                    <span class="text-orange">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <x-input-label for="map" :value="__('Emplacement de la zone sur le map')" class="mt-4"><span class="text-danger"><i class="bi bi-geo-alt-fill"></i></span></x-input-label>
                                    <div class="col-md-12">
                                        <div class="mb-3">

                                            {{-- IMPORTANT: préciser une hauteur sinon la carte n’apparaît pas --}}

                                            <!-- Div pour la carte -->
                                            <div id="map" style="height: 500px; width: 100%;"></div>

                                            <input type="text" name="map_lat" id="latitude" value="{{old('map_lat')}}">
                                            @error("map_lat")
                                            <span class="text-orange">{{$message}}</span>
                                            @enderror

                                            <input type="text" name="map_long" id="longitude" value="{{old('map_long')}}">
                                            @error("map_long")
                                            <span class="text-orange">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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

            const map = L.map('map').setView([6.370293, 2.391236], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

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
            map.addControl(drawControl);

            map.on(L.Draw.Event.CREATED, function(e) {
                const layer = e.layer;

                // Supprime l’ancienne zone
                drawnItems.clearLayers();
                drawnItems.addLayer(layer);

                let lat = null;
                let lng = null;

                if (layer instanceof L.Polygon || layer instanceof L.Rectangle) {
                    // Calculer le centre du polygone/rectangle
                    const bounds = layer.getBounds();
                    lat = bounds.getCenter().lat;
                    lng = bounds.getCenter().lng;
                } else if (layer instanceof L.Circle) {
                    const center = layer.getLatLng();
                    lat = center.lat;
                    lng = center.lng;
                }

                // Stocker dans les inputs
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;

                console.log("Latitude :", lat, "Longitude :", lng);
            });

        });
    </script>
    @endpush
</x-app-layout>