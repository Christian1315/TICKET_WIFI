<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RouterOS\Query;
use RouterOS\Client;

class PackageController extends Controller
{
    public function index()
    {
        $title = 'Supprimer le package!';
        $text = "Etes-vous sûr de supprimer ce package?";
        confirmDelete($title, $text);

        if (auth()->user()->isUser()) {
            $user = auth()->user();
            $router_name = $user->detail->router_name;
            $router = Router::with("packages")->where("name", $router_name)->firstOrFail();
            $packages = Package::with("router")->where('router_id', $router->id)->orderBy('name')->get();
            return view('packages.index', compact('packages'));
        }

        if (auth()->user()->isAdmin()) {
            $packages = Package::with("router")->orderBy('name')->get();
            return view('packages.index', compact('packages'));
        }
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $routers = Router::with("packages")->orderBy('name')->get();

        if ($routers->isEmpty()) {
            alert()->error("Opération échouée!", "Veuillez bien ajouter d'abord un router!");
            return back();
        }

        return view('packages.create', compact('routers'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:packages',
                'router_id' => 'required',
                'description' => 'nullable|string',
                'validation_time' => 'required',
                'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ], [
                "name.required" => "Le nom est requis!",
                "name.string" => "Le nom n'est pas valide",
                "name.max" => "Le nom ne doit pas dépasser 255 caractères!",
                "name.unique" => "Ce nom existe déjà",

                "validation_time.required" => "La durée de validité est réquise!",
                // "validation_time.time" => "Ce champ doit être de format date",

                "router_id.required" => "Selectionner un router",
                "name.integer" => "Ce champ doit être un entier",

                "price.required" => "Le prix est réquis",
                "price.numeric" => "Le prix doit être de format nuérique",
            ]);

            $router = Router::find($request->router_id);

            if (!$router) {
                throw new \Exception("Ce router n'existe pas", 1);
            }

            // Connexion au router
            // try {
            //     $client = new Client([
            //         "host" => $router->ip,
            //         "user" => $router->username,
            //         "pass" => $router->password,
            //     ]);

            //     $query = new Query("/ppp/profile/add");
            //     $query->equal("name", $request->name);
            //     $client->query($query)->read();
            // } catch (\Exception $e) {
            //     throw new \Exception("Echec de connexion au router", 1);
            // }

            $package = new Package();
            $package->fill($validated);
            $package->save();

            DB::commit();
            alert()->success("Opération réussie!", "Package crée avec succès!");

            return redirect('packages'); //->with('success', __('Package successfully added'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();

            alert()->error("Opération échouée!", "Erreure de validation");
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();

            alert()->error("Opération échouée!", "Erreure de lors de la création :" . $e->getMessage());
            return back()
                ->withInput();
        }
    }

    public function show(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        $routers = Router::all();

        return view('packages.show', compact('package','routers'));
    }

    public function edit(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        $routers = Router::all();
        return view('packages.edit', compact('package', 'routers'));
    }

    public function update(Request $request, Package $package)
    {
        $package->load("router");
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique("packages")->ignore($package->id)],
                'router_id' => 'required',
                'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ], [
                "name.required" => "Le nom est requis!",
                "name.string" => "Le nom n'est pas valide",
                "name.max" => "Le nom ne doit pas dépasser 255 caractères!",
                "name.unique" => "Ce nom existe déjà",

                "router_id.required" => "Selectionner un router",
                "name.integer" => "Ce champ doit être un entier",

                "price.required" => "Le prix est réquis",
                "price.numeric" => "Le prix doit être de format nuérique",
            ]);

            $package->update($validated);

            alert()->success("Opération réussie", "Modification éffectuée avec succès");
            return redirect('packages'); //->with('success', __('Package successfullly updated'));
        } catch (\Exception $e) {
            alert()->error("Opération échouée", "Modification échouée! ");
            return back()
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->load("router");

        try {
            DB::beginTransaction();
            
            if (!$package) {
                alert()->info("Information", "Ce package n'existe pas.");
                return back();
            }
            $package->delete();

            DB::commit();
            alert()->success("Opération réussie!", "Package supprimé avec succès!");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Une erreure est survenue lors de la suppression :" . $e->getMessage());
            return back();
        }
    }
}
