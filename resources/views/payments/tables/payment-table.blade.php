<table id="example1" class="table table-bordered table-striped table-sm">
    <thead class="text-white text-center bg-gradient-gray-dark">
        <tr>
            <th>N°</th>
            <th>Reference</th>
            <th>Utilisateur</th>
            <th>Tarif (package)</th>
            <th>Prix tarif({{env("CURRENCY")}})</th>
            <!-- <th>Début tarif</th> -->
            <th>Method de payment</th>
            <th>Date de payment</th>
        </tr>
    </thead>

    <tbody class="table-body">
        @foreach($payments as $payment)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>REF_{{$payment->invoice}}</td>
            <td> <span class="badge bg-light text-dark border">{{$payment->user?->name}}</span></td>
            <td class="text-center">{{$payment->billing?->package_name}}</td>
            <td class="text-center">{{$payment->package_price}}</td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($payment->package_start)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>
            <td class="text-center">
                <span class="badge bg-light text-primary border">{{$payment->payment_method}}</span>
            </td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($payment->created_at)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>
            <td class="text-center">
                <a target="_blank" href="{{route('invoice.download',$payment->id)}}" class="btn btn-sm btn-primary text-dark border text-white"><i class="bi bi-cloud-download"></i> &nbsp; {{ __('Télécharger') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>