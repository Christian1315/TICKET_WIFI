<table id="example1" class="table table-bordered table-striped table-sm">
    <thead class="text-white text-center bg-gradient-gray-dark">
        <tr>
            <th>N°</th>
            <th>Reference</th>
            <th>Tarif (package)</th>
            <th>Prix tarif({{env("CURRENCY")}})</th>
            <th>Début tarif</th>
            <th>Payement</th>
            <th>Date de Payement</th>
        </tr>
    </thead>

    <tbody class="table-body">
        @foreach($billings as $bill)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>REF_{{$bill->invoice}}</td>
            <td class="text-center">{{$bill->package_name}}</td>
            <td class="text-center">{{$bill->package_price}}</td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($bill->package_start)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>
            <td class="text-center">
                @if($bill->payment)
                <span class="badge bg-light text-primary border">Payé</span>
                @else
                <a href="{{route('payment.create',$bill->id)}}" class="btn btn-sm btn-primary text-dark border text-white"><i class="bi bi-wallet2"></i> &nbsp;Marquer comme payé</a>
                @endif
            </td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{$bill->payment?\Carbon\carbon::parse($bill->payment->created_at)->locale('fr')->isoFormat('D MMMM YYYY'):'---'}}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>