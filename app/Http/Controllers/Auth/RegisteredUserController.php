<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                "name.required" => "Le nom est réquis!",
                "name.string" => "Le nom doit être un string!",
                "name.max" => "Le nom ne doit pas dépassé 255 caractères!",

                "email.required" => "Le mail est réquis!",
                "email.string" => "Le mail doit être un string",
                "email.email" => "Le mail doit être de type email",
                "email.max" => "Les caractères ne doivent pas dépasse 225",
                "email.unique" => "Ce mail existe déjà",

                "password.required" => "Le mot de passe est réquis!",
                "password.confirmed" => "Les mots de passe ne sont pas identiques",
                "password.min" => "Le mot de passe doit contenir au moins :min caractères.",
                "password.letters" => "Le mot de passe doit contenir au moins une lettre.",
                "password.mixed" => "Le mot de passe doit contenir au moins une majuscule et une minuscule.",
                "password.numbers" => "Le mot de passe doit contenir au moins un chiffre.",
                "password.symbols" => "Le mot de passe doit contenir au moins un symbole.",
                "password.uncompromised" => "Le mot de passe saisi a été compromis dans une fuite de données. Veuillez en choisir un autre.",
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // SendNotification($user, "Création de compte", "Compte crée avec succès. Voici vos accès: Identifiant: $user->email | Mot de passe : $user->password ");

            // Auth::login($user);

            alert()->success("Succès", "Compte crée avec succès. Connectez-vous maintenant!");
            DB::commit();
            return redirect('/login')
                ->with("register_success", "Compte crée avec succès. Voici vos accès: Identifiant: $user->email | Mot de passe : $request->password ");
        } catch (\Exception $e) {
            Log::error("Erreure lors de la creation du compte", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            alert()->error("Echèc", "Erreure lors de la création du compte " . $e->getMessage());
            return back()->withInput();
        }
    }
}
