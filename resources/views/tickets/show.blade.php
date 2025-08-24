<x-app-layout>
    <x-slot name="title">Ticket | Détail</x-slot>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Ticket ID #') }} <span class="text-orange">{{$ticket->number}}</span>
                        </h2>

                        @if($ticket->status == "Open")
                        <form action="{{ route('close.ticket', $ticket->id) }}" method="post">
                            @csrf
                            <x-text-input name="ticket_id" type="hidden" value="{{ $ticket->id }}"></x-text-input>
                            <!-- <x-danger-button>{{ __('Close ticket') }}</x-danger-button> -->
                            <div class="flex justify-content-center items-center gap-4 mt-4">
                                <button type="submit" class="text-center ml-2 px-4 py-2 bg-orange btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                    <i class="bi bi-check-circle"></i> &nbsp; {{ __('Fermer le ticket') }}
                                </button>
                            </div>
                        </form>
                        @endif
                        @if($ticket->status == "Close")
                        <form action="{{ route('open.ticket', $ticket->id) }}" method="post">
                            @csrf
                            <x-text-input name="ticket_id" type="hidden" value="{{ $ticket->id }}"></x-text-input>
                            <!-- <x-success-button>{{ __('Re-open ticket') }}</x-success-button> -->
                            <div class="flex justify-content-center items-center gap-4 mt-4">
                                <button type="submit" class="text-center ml-2 px-4 py-2 bg-orange btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                    <i class="bi bi-check-circle"></i> &nbsp; {{ __('Re-Ouvrir le ticket') }}
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>

                    <div class="mt-6 font-semibold">
                        {{ __('Sujet: ') . $ticket->subject }}
                    </div>

                    <div class="mt-2 text-xs">
                        {{ __('Crée par: ') . $ticket->user->name . __(' le: ')  }} <span class="text-orange"> {{\Carbon\carbon::parse($ticket->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</span>
                    </div>

                    <div class="mt-6">
                        {{ $ticket->message }}
                    </div>

                    <div class="my-6 border border-gray-100"></div>

                    <div>
                        @foreach($comments as $comment)
                        <p class="mt-6 text-xs">
                            {{ __('Commenté par: ')}} <span class="text-orange">{{$comment->user?->name }}</span> fait le  <span class="text-orange"> {{\Carbon\carbon::parse($comment->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</span>
                        </p>
                        <p class="mt-2">
                            {{ $comment->comment }}
                        </p>
                        @endforeach

                        @if($ticket->status == "Open")
                        <form action="{{ route('add.comment') }}" method="post">
                            @csrf
                            <div>
                                <x-input-label for="comment" :value="__('Ajouter un commentaire')" class="mt-4"> <span class="text-danger">*</span> </x-input-label>
                                <textarea name="comment" class="px-3 py-3 mt-1 rounded-lg border-gray-300 md:text-sm block w-full" rows="2" required placeholder="Ex: Début de fermeture du ticket..."></textarea>
                                @error("comment")
                                <span class="text-orange">{{$message}}</span>
                                @enderror
                            </div>
                            <x-text-input name="ticket_id" type="hidden" value="{{ $ticket->id }}"></x-text-input>

                            <div class="flex justify-content-center items-center gap-4 mt-4">
                                <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                    <i class="bi bi-check-circle"></i> &nbsp; {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </form>

                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>