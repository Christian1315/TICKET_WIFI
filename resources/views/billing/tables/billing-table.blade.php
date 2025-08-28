<table id="example1" class="table table-bordered table-striped table-sm">
    <thead class="text-white text-center bg-gradient-gray-dark">
        <tr>
            <th>N°</th>
            <th>Reference</th>
            <th>Utilisateur</th>
            <!-- <th>Tarif (package)</th> -->
            <th>Prix ({{env("CURRENCY")}})</th>
            <th>Payement</th>
            <th>Tickets</th>
            <th>Date de Payement</th>
        </tr>
    </thead>

    <tbody class="table-body">
        @foreach($billings as $bill)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>REF_{{$bill->invoice}}</td>
            <td> <span class="badge bg-light text-dark border">{{$bill->user?->name}}</span></td>
            <!-- <td class="text-center">{{$bill->package_name}}</td>
            <td class="text-center">{{$bill->package_price}}</td> -->
            <td class="text-center"><span class="badge bg-light border text-dark"> {{number_format($bill->price,2,","," ")}}</span></td>
            <td class="text-center">
                @if($bill->payment)
                <span class="badge bg-light text-primary border">Payé</span>
                @else
                <a href="{{route('payment.create',$bill->id)}}" class="btn btn-sm btn-primary text-dark border text-white"><i class="bi bi-wallet2"></i> &nbsp; Payer la facture</a>
                @endif
            </td>
            <td>
                <div class="border rounded w-100" style="height:50px!important;overflow-y:scroll">
                    @foreach($bill->tickets as $tciket)
                    <span class="badge bg-light text-dark border">{{$tciket->number}}</span><br>
                    @endforeach
                </div>
            </td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{$bill->payment?\Carbon\carbon::parse($bill->payment->created_at)->locale('fr')->isoFormat('D MMMM YYYY'):'---'}}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>