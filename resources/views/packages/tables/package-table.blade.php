<table id="example1" class="table table-bordered table-striped table-sm">
    <thead class="text-white text-center bg-gradient-gray-dark">
        <tr>
            <th>N°</th>
            <th>Router</th>
            <th>Nom</th>
            <th>Prix {{env(config('app.currency'))}}</th>
            <th>Crée le</th>
            <th>Modifiée le</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody class="table-body">
        @foreach($packages as $package)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$package->router?->name}}</td>
            <td>{{$package->price}}</td>
            <td class="text-center"><span class="badge bg-light text-dark border">{{\Carbon\carbon::parse($package->created_at)->locale("fr")->isoFormat("D MMMM YYYY")}}</span></td>
            <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($router->updated_at)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>

            <td class="text-center">
                <div name="btn-group" role="group">
                    <!-- Update -->
                    <a href="{{route('package.edit', $router->id)}}" class="btn btn-sm bg-orange text-dark"><i class="bi bi-pencil"></i> Modifier</a>
                    <!-- Form delete -->
                    <a href="{{route('package.destroy', $router->id)}}" class="btn btn-sm btn-danger text-white" data-confirm-delete="true"><i class="bi bi-trash3"></i> Supprimer</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>