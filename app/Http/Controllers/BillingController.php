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
            $billings = $user->billing;
        } else {
            $billings = Billing::with(["user","payment"])->get();
        }
        return view('billing.index', compact("billings"));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            alert()->info("Accès refusé!", "Vous n'avez pas accès à ce panel!");
            return redirect('/');
        }

        $users = User::where('role', 'user')
            ->with('detail')
            ->whereHas('detail', function (Builder $query) {
                $query->where('status', 'active');
            })->orderBy('name')->get();

        return view('billing.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (!$request->checked) {
                alert()->info("Opération bloquée!", "Veuillez selectionnez au moins un utiisateur");
                return back();
            }

            if (is_array($request->user_id) || is_object($request->user_id)) {
                foreach ($request->user_id as $key => $val) {
                    $billing = new Billing();
                    if (is_array($request->checked) && in_array($val, $request->checked, true)) {
                        $user = User::where('id', $val)->first();
                        $billing->invoice = $billing->generateRandomNumber();
                        $billing->package_name = $user->detail->package_name;
                        $billing->package_price = $user->detail->package_price;
                        $billing->package_start = Carbon::now();
                        $billing->user_id = $user->id;
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
