<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request, $userId, $userEmail): View
    {
        return view('auth.reset-password', ["userId" => $userId, "userEmail" => $userEmail]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        try {
            DB::beginTransaction();

            $request->validate([
                // 'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::find($request->userId);

            if (!$user) {
                alert()->info("Information", "Cet utilisateur n'existe pas!");
                return back()->withInput();
            }

            $user->update([
                "password" => Hash::make($request->password),
                "email" => $request->email
            ]);

            alert()->success("Succès", "Mot de passe modifié avec succès! Connectez-vous mainteant.");
            DB::commit();
            return redirect()->route("login");
        } catch (\Throwable $th) {
            alert()->success("Succès", "Mot de passe modifié avec succès! Connectez-vous mainteant.");
            return redirect()->route("login");
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation',"token"),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => Hash::make($request->password),
        //             'remember_token' => Str::random(60),
        //         ])->save();

        //         event(new PasswordReset($user));
        //     }
        // );




        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // return $status == Password::PASSWORD_RESET
        //     ? redirect()->route('login')->with('status', __($status))
        //     : back()->withInput($request->only('email'))
        //     ->withErrors(['email' => __($status)]);
    }
}
