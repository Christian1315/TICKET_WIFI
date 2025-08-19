<?php

namespace App\Http\Controllers;

// use App\Models\User;

use App\Notifications\SendContactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view("home");
    }

    /**
     * Contact Me
     */

    function contactMe(Request $request)
    {
        try {
            /**
             * Validation des données
             */
            $validated = $request->validate([
                "name" => "required|string",
                "email" => "required|email",
                "objet" => "required|string",
                "phone" => "required|numeric",
                "message" => "required|string",
            ], [
                "name.required" => "Le nom est réquis",
                "name.string" => "Le nom doit être un texte",

                "email.required" => "Le mail est réquis",
                "email.email" => "Le mail doit être de format mail",

                "objet.required" => "L'objet est réquis",
                "objet.string" => "L'objet doit être de type texte",

                "phone.required" => "Le numéro de téléphone est réquis",
                "phone.numeric" => "Le numéro de téléphone doit être de format numbre",

                "message.required" => "Le message est réquis",
            ]);

            /**
             * Envoie du mail
             */
            $data = array_merge($validated, ["subject" => $validated["objet"]]);
            SendNotificationViaMail(
                $data,
                new SendContactNotification($data)
            );

            alert()->success("Opération réussie", "Contact envoyé avec succès! L'administrateur vous fera un retour dans un intant! Veuillez bien patienter!");
            return back()->withInput();
        } catch (\Exception $e) {
            Log::debug("Erreure lors de l'envoie de contact via mail " . $e->getMessage());

            alert()->error("Opération échouée", "Erreure lors de l'envoie de contact via mail");
            return back()->withInput();
        }
    }
}
