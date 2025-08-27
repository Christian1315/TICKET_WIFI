<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::firstWhere(["email" => $request->email]);
            /**On verifie si le user est connecté a un compte actif ou pas */
            if ($user) {
                if ($user->detail && $user->detail->status != "active") {
                    alert()->error("Votre compte a été désactivé!");
                    return back()->withInput();
                }
            }

            $request->authenticate();
            $request->session()->regenerate();

            DB::commit();
            alert()->success("Succès", "Vous êtes connecté.e avec succès!");
            return redirect('/dashboard');
        } catch (\Exception $e) {

            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure lors de la connexion : " . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        alert()->success("Succès", "Vous êtes déconnecté.e avec succès!");
        return redirect('/login');
    }
}
