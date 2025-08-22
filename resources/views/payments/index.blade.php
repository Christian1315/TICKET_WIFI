<x-app-layout>
    <x-slot name="title">Payement</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            <i class="bi bi-wallet2"></i> &nbsp; {{ __('Paiements') }}
                        </h2>
                        <div class="flex items-center">
                            @if (auth()->user()->isAdmin())
                            <a href="{{ route('payment.download') }}" class="text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                <i class="bi bi-cloud-download"></i> &nbsp; {{ __('Télécharger') }}
                            </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if (auth()->user()->isAdmin())
                        <!-- livewire:payment-table /> -->
                        @include("payments.tables.payment-table")
                        @endif
                        @if (auth()->user()->isUser())
                        <!-- livewire:user-payment-table /> -->
                        @include("payments.user-tables.payment-table")
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>