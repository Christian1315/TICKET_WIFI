<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->isAdmin()) {
            $billings = $user->billing
                ->load(["user", "payment"]);
        } else {
            $billings = Billing::with(["user", "payment"])->get();
        }
        return view('billing.index', compact("billings"));
    }

    public function create()
    {
        $users = User::where('role', 'user')
            ->with('detail')
            ->whereHas('detail', function (Builder $query) {
                $query->where('status', 'active');
            })->latest()->get();

        return view('billing.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // $request->validate([
            //     "users" => "required|array",
            //     "users*id" => "required|integer",
            //     "users*checked" => "required",
            //     "users*price" => "required",
            // ]);


            if (!$request->users) {
                alert()->info("Opération bloquée!", "Veuillez selectionnez au moins un utiisateur");
                return back();
            }
            // dd($request->users);

            if (is_array($request->users) || is_object($request->users)) {
                foreach ($request->users as $val) {
                    if (isset($val["checked"]) && isset($val["checked"])=="on") {
                        $billing = new Billing();
                        $billing->invoice = $billing->generateRandomNumber();
                        $billing->user_id = $val["user_id"];
                        $billing->price = $val["price"];
                        $billing->save();
                    }
                }
            }

            DB::commit();
            alert()->success("Opération réussie!", "Facture générée avec succès!");
            return redirect()->route("billing.index"); // redirect('/billing');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure de generation de facture " . $e->getMessage());
            alert()->error("Opération échouée!", "Erreure de generation de facture!");
            return back();
        }
    }
}
