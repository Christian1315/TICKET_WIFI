<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Detail;
use App\Models\Package;
use App\Models\Router;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use RouterOS\Client;
// use RouterOS\Query;
use App\Models\User;
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        if (auth()->user()->isUser()) {
            return redirect('/');
        }

        $users = User::with('detail')->where('role', 'user')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $packages = Package::orderBy('name')->get();
        $routers = Router::with('packages')->get();

        return view('users.create', compact('packages', 'routers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|confirmed",
            "address" => "required",
            "phone" => "required",
            "dob" => "required|date",
            "pin" => "required|numeric",

            "router_id" => "required|integer",
            "package_id" => "required|integer",
        ], [
            "name.required" => "Le nom est réquis",

            "email.required" => "Le mail est réquis!",
            "email.email" => "Le mail n'est pas valide",
            "email.unique" => "Ce mail existe déjà!",

            "password.required" => "Le mot de passe est réquis!",
            "password.min" => "6 caractères sont réquis au minimun",
            "password.confirmed" => "Les mots de passe ne sont pas identiques",

            "address.required" => "L'adresse est réquise!",

            "dob.required" => "La date de naissance est réquise!",
            "dob.date" => "La date de naissance n'est pas valide",

            "pin.required" => "Le numéro d'identification personnelle est réquis!",
            "pin.numeric" => "Ce champ doit être de format numérique!",

            "pin.numeric" => "Ce champ doit être de format numérique!",

            "router_id.required" => "Ce champ est réquis!",
            "router_id.integer" => "Ce champ est n'est pas valide!",

            "package_id.required" => "Ce champ est réquis!",
            "package_id.integer" => "Ce champ est n'est pas valide!",
        ]);

        $router = Router::find($request->router_id);
        $package = Package::find($request->package_id);

        if (!$router) {
            throw new \Exception("Ce router n'existe pas:");
        }

        if (!$package) {
            throw new \Exception("Ce package n'existe pas:");
        }

        // try {
        //     $client = new Client([
        //         "host" => $router->ip,
        //         "user" => $router->username,
        //         "pass" => $router->password,
        //     ]);

        //     $query = new Query("/ppp/secret/add");
        //     $query->equal("name", $request->name);
        //     $query->equal("password", $request->router_password);
        //     $query->equal("service", 'any');
        //     $query->equal("profile", $package->name);
        //     $client->query($query)->read();
        // } catch (\Exception $e) {
        //     alert()->error("Opération échouée!", "Echec de connexion au mikrotik");
        //     return back()->withInput();
        // }

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'user';
            $user->password = Hash::make($request->password);
            $user->save();

            $details = new Detail();
            $details->phone = $request->phone;
            $details->address = $request->address;
            $details->dob = $request->dob;
            $details->pin = $request->pin;
            $details->router_password = $router->password; // $request->router_password;
            $details->package_name = $package->name;
            $details->router_name = $router->name;
            $details->package_price = $package->price;
            $details->due = $package->price;
            $details->status = 'active';
            $details->package_start = Carbon::now();
            $details->user_id = $user->id;
            $details->save();

            $billing = new Billing();
            $billing->invoice = $billing->generateRandomNumber();
            $billing->package_name = $details->package_name;
            $billing->package_price = $details->package_price;
            $billing->package_start = $details->package_start;
            $billing->user_id = $user->id;
            $billing->save();

            DB::commit();
            alert()->success("Opération réussie!", "Utilisateur ajouter avec succès");
            return redirect()->route("users.index");
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure de validation!");
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Une erreure est survenue lors de l'opération : " . $e->getMessage());
            return back()
                ->withInput();
        }
    }

    public function show(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $routers = Router::with("packages")->get();
        return view('users.edit', compact('user', 'routers'));
    }

    public function update(Request $request, User $user)
    {

        try {
            $validated = $request->validate([
                "name" => "required",
                "email" => ["required", "email", Rule::unique("users")->ignore($user->id)],
                "password" => "required|min:6|confirmed",
                "address" => "required",
                "phone" => "required",
                "dob" => "required|date",
                "pin" => "required|numeric",

                "router_id" => "required|integer",
                "package_id" => "required|integer",
            ], [
                "name.required" => "Le nom est réquis",

                "email.required" => "Le mail est réquis!",
                "email.email" => "Le mail n'est pas valide",
                "email.unique" => "Ce mail existe déjà!",

                "password.required" => "Le mot de passe est réquis!",
                "password.min" => "6 caractères sont réquis au minimun",
                "password.confirmed" => "Les mots de passe ne sont pas identiques",

                "address.required" => "L'adresse est réquise!",

                "dob.required" => "La date de naissance est réquise!",
                "dob.date" => "La date de naissance n'est pas valide",

                "pin.required" => "Le numéro d'identification personnelle est réquis!",
                "pin.numeric" => "Ce champ doit être de format numérique!",

                "pin.numeric" => "Ce champ doit être de format numérique!",

                "router_id.required" => "Ce champ est réquis!",
                "router_id.integer" => "Ce champ est n'est pas valide!",

                "package_id.required" => "Ce champ est réquis!",
                "package_id.integer" => "Ce champ est n'est pas valide!",
            ]);
            DB::beginTransaction();

            $validated["password"] = Hash::make($request->password);
            $user->update($validated);

            $router = Router::find($validated["router_id"]);
            $package = Package::find($validated["package_id"]);

            if (!$router) {
                throw new \Exception("Ce router n'existe pas:");
            }

            if (!$package) {
                throw new \Exception("Ce package n'existe pas:");
            }

            $validated["router_password"] = $router->password; // $request->router_password;
            $validated["package_name"] = $package->name;
            $validated["router_name"] = $router->name;
            $validated["package_price"] = $package->price;
            $validated["due"] = $package->price;
            $validated["status"] = 'active';
            $validated["package_start"] = Carbon::now();
            $validated["phone"] = $request->phone;
            $validated["address"] = $request->address;
            $validated["dob"] = $request->dob;
            $validated["pin"] = $request->pin;

            $user->detail()->update(Arr::except($validated, ['name', 'email',"password","router_id","package_id"]));

            DB::commit();
            alert()->success("Opération réussie!", "Utilisateur modifié avec succès");
            return redirect()->route("users.index"); //->with("success", __("User added successfully"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure de validation!");
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure d'enregistrement", ["data" => $e->getMessage(), "line" => $e->getLine()]);
            alert()->error("Opération échouée!", "Erreure d'enregistrement");
            return back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }
}
