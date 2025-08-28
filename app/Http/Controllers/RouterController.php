<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRouterRequest;
use App\Http\Requests\UpdateRouterRequest;
use Illuminate\Http\Request;
use App\Models\Router;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Supprimer le router!';
        $text = "Etes-vous sûr de supprimer ce router?";
        confirmDelete($title, $text);

        $user = auth()->user();
        if ($user->isUser()) {
            $routers = $user->routers->load("user");
        } else {
            $routers = Router::with("user")->orderBy("name", "asc")->get();
        }
        return view("router.index", compact("routers"));
    }


    public function routerLocalization(Request $request)
    {
        return view("router_localisation");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('router.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:routers',
                'location' => 'required',
                'ip' => 'required|ip|unique:routers',
                'username' => 'required',
                'password' => 'required',

                'type' => "required|in:Mikrotik,PfSence,Omada",
                'contact' => "required",
                'description' => "nullable|string",

                'map_lat' => "nullable|numeric",
                'map_long' => "nullable|numeric",
            ], [
                'name.required' => "Le nom du router est réquis",
                'name.string' => "Le nom du être un texte",
                'name.max' => "Le caractère maximal doit être 225",
                'name.unique' => "Ce router existe déjà",

                'location.required' => "L'emplacement du router est réquis!",

                'ip.required' => "L'IP est réquis!",
                'ip.ip' => "L'adresse Ip n'est pas valide!",
                'ip.unique' => "L'adresse Ip exisyte déjà!",

                'username.required' => "L'identifiant est réquis'",
                'password.required' => "Le mot de passe est réquis!",

                'type.required' => "Préciser le type du router",
                'type.enum' => "Le type doit être 'Mikrotik','PfSence' ou 'Omada'",

                'contact.required' => "Le contact est réquis!",

                'map_lat.numeric' => "Ce champ doit être de type numérique",
                'map_long.numeric' => "Ce champ doit être de type numérique",
            ]);

            DB::beginTransaction();

            auth()->user()
                ->routers()->create($validated);

            // $router = new Router();
            // $router->fill($validated);
            // $router->save();

            alert()->success("Opération réussie!", "Router crée avec succès!");
            DB::commit();
            return redirect()->route("router.index"); // redirect('router')->with('success', __('Router successfully added'));
        } catch (ValidationException $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure de validation des données");
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure lors de la création du router", ["error" => $e->getMessage()]);
            alert()->error("Opération échouée!", "Erreure lors de la création du router ");
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Router $router)
    {
        return view('router.show', compact('router'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Router $router)
    {
        return view('router.edit', compact('router'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Router $router)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique("routers")->ignore($router->id)],
                'location' => 'required',
                'ip' => ['required', 'ip', Rule::unique("routers")->ignore($router->id)],
                'username' => 'required',
                'password' => 'required',

                'contact' => "required",
                'description' => "nullable|string",

                'type' => "required|in:Mikrotik,PfSence,Omada",
                'map_long' => "nullable|numeric",
                'map_lat' => "nullable|numeric",

            ], [
                'name.required' => "Le nom du router est réquis",
                'name.string' => "Le nom du être un texte",
                'name.max' => "Le caractère maximal doit être 225",
                'name.unique' => "Ce router existe déjà",

                'location.required' => "L'emplacement du router est réquis!",


                'contact.required' => "Le contact est réquis!",

                'ip.required' => "L'IP est réquis!",
                'ip.ip' => "L'adresse Ip n'est pas valide!",
                'ip.unique' => "L'adresse Ip exisyte déjà!",

                'username.required' => "L'identifiant est réquis'",
                'password.required' => "Le mot de passe est réquis!",

                'type.required' => "Préciser le type du router",
                'type.enum' => "Le type doit être 'Mikrotik','PfSence' ou 'Omada'",

                'map_lat.numeric' => "Ce champ doit être de type numérique",
                'map_long.numeric' => "Ce champ doit être de type numérique",
                'type.in' => "Ce champ doit être de type numérique",
            ]);

            DB::beginTransaction();

            $router->update($validated);

            DB::commit();
            alert()->success("Opération réussie!", "Modification éffectuée avec succès!");
            return redirect()->route("router.index"); // redirect('router')->with('success', __('Router updated successfully'));
        } catch (ValidationException $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure de validation!");
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure lors de la modification " . $e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Router $router)
    {
        try {
            DB::beginTransaction();
            if (!$router) {
                alert()->info("Information", "Ce router n'existe pas.");
                return back();
            }

            $router->delete();

            DB::commit();
            alert()->success("Opération réussie!", "Router supprimé avec succès!");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Une erreure est survenue lors de la suppression :" . $e->getMessage());
            return back();
        }
    }
}
