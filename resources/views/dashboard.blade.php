<x-app-layout>
    <x-slot name="title">{{__('Tableau de bord')}}</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-8 border-b-2 border-slate-100 pb-4">
                        {{ __('Tableau de bord') }}
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 mb-6">
                        <div class="shadow border border-gray-200 p-4 rounded flex flex-col items-center justify-center">
                            <p class="text-2xl mt-2 font-bold"> <strong class="text-orange">{{number_format($totalBills,2,","," ")}} </strong> {{config('app.currency') }}</p>
                            <h2 class="text-l">{{ __('Total des factures') }}</h2>
                        </div>
                        <div class="shadow border border-gray-200 p-4 rounded flex flex-col items-center justify-center">
                            <p class="text-2xl mt-2 font-bold"><strong class="text-orange">{{number_format($totalPayments,2,","," ")}} </strong> {{config('app.currency') }}</p>
                            <h2 class="text-l">{{ __('Total des paiements') }}</h2>
                        </div>
                        <div class="shadow border border-gray-200 p-4 rounded flex flex-col items-center justify-center">
                            <p class="text-2xl mt-2 font-bold"><strong class="text-orange">{{number_format($billsThisMonth,2,","," ")}} </strong> {{ config('app.currency') }}</p>
                            <h2 class="text-l">{{ __('Factures de ce mois-ci') }}</h2>
                        </div>
                        <div class="shadow border border-gray-200 p-4 rounded flex flex-col items-center justify-center">
                            <p class="text-2xl mt-2 font-bold"><strong class="text-orange">{{number_format($paymentsThisMonth,2,","," ")}} </strong> {{config('app.currency') }}</p>
                            <h2 class="text-l">{{ __('Paiements ce mois-ci') }}</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="mt-6 mb-6 font-semibold">{{ __('Facturation et paiement mensuels') }}</h3>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div>
                            <h3 class="mt-6 mb-6 font-semibold">{{ __('Facturation et paiement journaliers') }}</h3>
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>

                    @if(auth()->user()->isAdmin())
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="border-l-2 bg-neutral-50 border-neutral-500 p-4">
                            <h2 class="text-l font-bold">{{ __('Total des utilisateurs') }}</h2>
                            <p class="text-xl mt-2 font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="border-l-2 bg-neutral-50 border-neutral-500 p-4">
                            <h2 class="text-l font-bold">{{ __('Utilisateur en retard de paiement') }}</h2>
                            <p class="text-xl mt-2 font-bold">{{ $usersWithDueCount }}</p>
                        </div>
                        <div class="border-l-2 bg-neutral-50 border-neutral-500 p-4">
                            <h2 class="text-l font-bold">{{ __('Factures de cette année') }}</h2>
                            <p class="text-xl mt-2 font-bold">{{ $billsThisYear.' '. config('app.currency') }}</p>
                        </div>
                        <div class="border-l-2 bg-neutral-50 border-neutral-500 p-4">
                            <h2 class="text-l font-bold">{{ __('Paiements de cette année') }}</h2>
                            <p class="text-xl mt-2 font-bold">{{ $paymentsThisYear.' '. config('app.currency') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-semibold">{{ __('Utilisateurs récents') }}</h3>
                                <table id="" class="table-auto border-collapse border-b border-slate-400 mt-4 w-full">
                                    <thead>
                                        <tr>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Nom') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Package (Tarif)') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Crée le') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentUsers as $user)
                                        <tr>
                                            <td class="border-b border-slate-300 p-2">{{ $user->name }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ $user->detail?->package_name }}</td>
                                            <td class="border-b border-slate-300 p-2">{{\Carbon\carbon::parse($user->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ __('Paiements recents') }}</h3>
                                <table class="table-auto border-collapse border-b border-slate-400 mt-4 w-full">
                                    <thead>
                                        <tr>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Utilisateur') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Montant') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentPayments as $payment)
                                        <tr>
                                            <td class="border-b border-slate-300 p-2">{{ $payment->user->name }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ $payment->package_price .' '. config('app.currency') }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ \Carbon\carbon::parse($payment->created_at)->locale("fr")->isoFormat("D MMMM YYYY") }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-semibold">{{ __('Utilisateurs impayés') }}</h3>
                                <table class="table-auto border-collapse border-b border-slate-400 mt-4 w-full">
                                    <thead>
                                        <tr>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Nom') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Package (Tarif)') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Dette') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usersWithDueList as $user)
                                        <tr>
                                            <td class="border-b border-slate-300 p-2">{{ $user->name }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ $user->detail?->package_name }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ $user->due_amount($user->id) .' '. config('app.currency') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ __('Tickets récents') }}</h3>
                                <table class="table-auto border-collapse border-b border-slate-400 mt-4 w-full">
                                    <thead>
                                        <tr>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Subject') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Status') }}</th>
                                            <th class="border-b border-slate-300 p-2 text-left bg-slate-50">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTickets as $ticket)
                                        <tr>
                                            <td class="border-b border-slate-300 p-2">{{ $ticket->subject }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ $ticket->status }}</td>
                                            <td class="border-b border-slate-300 p-2">{{ \Carbon\carbon::parse($ticket->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const billingData = @json($billingData);
        const paymentData = @json($paymentData);

        const labels = [
            'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin',
            'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'
        ];

        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Montant facturé (mensuel)',
                        data: billingData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Montant payé (mensuel)',
                        data: paymentData,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 
        // const labelsDaily = [
        //     'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin',
        //     'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'
        // ];

        const labelsDaily = Array.from({
            length: billingData.length
        }, (_, i) => (i + 1).toString());

        const daylyCtx = document.getElementById('dailyChart').getContext('2d');
        new Chart(daylyCtx, {
            type: 'bar',
            data: {
                labels: labelsDaily,
                datasets: [{
                        label: 'Montant facturé (mensuel)',
                        data: billingData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Montant payé (mensuel)',
                        data: paymentData,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>