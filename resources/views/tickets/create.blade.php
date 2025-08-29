<x-app-layout>
    <x-slot name="title">Ticket | Créer</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        <i class="bi bi-node-plus"></i> &nbsp; {{ __('Ajouter un Ticket') }}
                    </h2>

                    <form method="post" action="{{ route('ticket.store') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ __('Ticket') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">{{ __("Créer un nouveau ticket") }}</p>
                        </div>

                        <!-- Retour sur liste -->
                        <div class="flex justify-content-center mt-3">
                            <a href="{{route('ticket.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                                <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                            </a>
                        </div>
                        <br>

                        <!-- Info -->
                        <div class="alert alert-warning border-left border-bold">
                            <i class="bi bi-info-circle"></i> Les champs portant le signe (<span class="text-danger">*</span>) sont réquis!
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <x-input-label for="type_id" :value="__('Type d\'opération')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <select id="type_id" class="mt-1 block w-full rounded-md border border-gray-300" required>
                                    <option value="uploader">Uploader un ticket</option>
                                    <option value="generer">Génerer un ticket</option>
                                </select>
                            </div>

                            <div class="">
                                <x-input-label for="subject" :value="__('Sujet')"> <span class="text-danger">*</span> </x-input-label>
                                <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" :value="old('subject')" required placeholder="Ex: Ticket 1"></x-text-input>
                                @error("subject")
                                <span class="text-orange">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <x-input-label for="package_id" :value="__('Tarif (Package)')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <select name="package_id" id="package_id" class="mt-1 block w-full rounded-md border border-gray-300" required>
                                    @foreach($packages as $package)
                                    <option
                                        @disabled($package->user_id!=Auth::id())
                                        @selected(old('package_id')==$package->id) value="{{$package->id}}">{{$package->name}}</option>
                                    @endforeach
                                </select>
                                @error("package_id")
                                <span class="text-orange">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="priority" :value="__('Priorité')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <select name="priority" id="priority" class="mt-1 block w-full rounded-md border border-gray-300" required>
                                    <option @selected(old('priority')=='Elevée' ) value="Elevée">{{ __('Elevé') }}</option>
                                    <option @selected(old('priority')=='Normale' ) value="Normale">{{ __('Normal') }}</option>
                                    <option @selected(old('priority')=='Faible' ) value="Faible">{{ __('Faible') }}</option>
                                </select>
                                @error("priority")
                                <span class="text-orange">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="my-3" id="ticket_file">
                                <x-input-label for="ticket_file" :value="__('Uploader le ticket')"> <span class="text-danger">*</span> </x-input-label>
                                <x-text-input id="ticket_file" name="ticket_file" type="file" class="mt-1 block w-full form-control" :value="old('ticket_file')"></x-text-input>
                                @error("ticket_file")
                                <span class="text-orange">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="message" :value="__('Message')" class="mt-4"><span class="text-danger">*</span></x-input-label>
                                <textarea name="message" class="px-3 py-3 mt-1 rounded-lg border-gray-300 md:text-sm block w-full" rows="2" placeholder="Ex: Ticket de test" required></textarea>
                                @error("message")
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


    @push("scripts")
    <script>
        $(document).ready(function() {
            $("#type_id").on("select2:select", function(e) {
                const selected = $(this).find(':selected')
                // alert(e.params.data.id)

                if (e.params.data.id == "generer") {
                    $("#ticket_file").addClass("d-none")
                }else{
                    $("#ticket_file").removeClass("d-none");
                }
            })
        })
    </script>
    @endpush
</x-app-layout>