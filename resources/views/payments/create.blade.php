<x-app-layout>
    <x-slot name="title">Payement | Créer</x-slot>

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
                        <i class="bi bi-node-plus"></i> &nbsp; {{ __('Effectuer un paiement') }}
                    </h2>

                    <!-- Retour sur liste -->
                    <div class="flex justify-content-center mt-3">
                        <a href="{{ route('billing.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                            <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                        </a>
                    </div>
                    <br>

                    <form action="#" method="POST" id="_payment-form">
                        @csrf

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-8">
                                <h2 class="text-lg font-medium text-gray-900">{{ __('Paiement de la facture')}} <span class="badge bg-light text-dark border">REF_{{ $bill->invoice }}</span> valant la somme de <span class="badge bg-primary text-white">{{ number_format($bill->price,2,","," ") .' '.env('CURRENCY')}} </span></h2>
                                <p class="mt-1 text-sm text-gray-600">{{ __("Paiement disponible uniquement pour kkiapay") }}</p>
                                <br>
                                @php
                                    $admin = \App\Models\User::find(1);
                                @endphp
                                
                                @if(!$admin->detail)
                                <p class="mt-1 text-sm text-gray-600">{{ __("La clé Kkiapay n'est pas configué, vous ne pouvez éffectuer cette transaction! Veuillez contacter l'administrateur pour l'urgence avant de continuer!") }}</p>
                                @endif

                                @if($bill->payment)
                                <p class="mt-1 text-sm text-gray-600">{{ __("Cette facture a déjà été payée!") }}</p>
                                @endif

                                <input type="hidden" name="bill" value="{{ $bill->id }}">
                                <input type="hidden" name="amount" value="{{ $bill->price }}">
                                <input type="hidden" name="payment_method" id="payment_method" value="">
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert"></div>
                                <div class="flex justify-content-center items-center gap-4 mt-4">
                                  
                                    
                                    @if($admin->detail && !$bill->payment)
                                    <script
                                        amount="{{$bill->price}}"
                                        key="{{auth()->user()->detail?auth()->user()->detail->kkiapay_key:''}}"
                                        sandbox="true"
                                        position="right"
                                        theme="#0095ff"
                                        callback="{{route('payment.handlePayementAfterProcess',$bill->id)}}"
                                        src="https://cdn.kkiapay.me/k.js">
                                    </script>

                                    <button type="button" class="kkiapay-button w-100 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                        <i class="bi bi-check-circle"></i> &nbsp; {{ __('Payer maintenant') }}
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('
            services.stripe.key ') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const paymentForm = document.getElementById('payment-form');
        paymentForm.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createPaymentMethod('card', cardElement)
                .then(function(result) {
                    if (result.error) {
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        const paymentMethodInput = document.getElementById('payment_method');
                        paymentMethodInput.value = result.paymentMethod.id;
                        paymentForm.submit();
                    }
                });
        });
    </script>
    @endpush

</x-app-layout>