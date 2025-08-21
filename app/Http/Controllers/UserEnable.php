<?php

namespace App\Http\Controllers;

use App\Models\Router;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RouterOS\Client;
use RouterOS\Query;

class UserEnable extends Controller
{
    public function __invoke(User $user)
    {
        try {
            DB::beginTransaction();

            $router_name = $user->detail->router_name;
            $router = Router::firstWhere("name", $router_name);

            if (!$router) {
                throw new \Exception("Ce router n'existe pas!");
            }

            // try {
            //     $client = new Client([
            //         "host" => $router->ip,
            //         "user" => $router->username,
            //         "pass" => $router->password,
            //     ]);

            //     $query = new Query("/ppp/secret/enable");
            //     $query->equal("numbers", $user->name);
            //     $client->query($query)->read();
            // } catch (\Exception $e) {
            //     return back()->with("error", __("Mikrotik connection fails"));
            // }

            DB::commit();
            $user->detail->update(["status" => 'active']);
            alert()->success("Opération réussie!", "Compte activé avec succès!");
            return back(); //->with("success", __("User disabled successfully"));
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure lors de l'activation du compte");
            return back();
        }
    }
}
