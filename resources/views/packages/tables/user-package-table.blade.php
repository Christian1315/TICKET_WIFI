<table id="example1" class="table table-bordered table-striped table-sm">
    <thead class="text-white text-center bg-gradient-gray-dark">
        <tr>
            <th>N°</th>
            <th>Nom</th>
            <th>Prix {{env(config('app.currency'))}}</th>
            <th>Crée le</th>
        </tr>
    </thead>

    <tbody class="table-body">
        @foreach($packages as $package)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$package->name}}</td>
            <td>{{$package->price}}</td>
            <td class="text-center"><span class="badge bg-light text-dark border">{{\Carbon\carbon::parse($package->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>