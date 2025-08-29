<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Flare;
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
                ->load(["user", "payment", "tickets"]);
        } else {
            $billings = Billing::with(["user", "payment", "tickets"])->get();
        }
        return view('billing.index', compact("billings"));
    }

    public function create()
    {
        $users = User::where('role', 'user')
            ->with('detail', 'tickets.package')
            ->whereHas('detail', function (Builder $query) {
                $query->where('status', 'active');
            })->latest()->get();

        return view('billing.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if (!$request->users) {
                alert()->info("Opération bloquée!", "Veuillez selectionnez au moins un utiisateur");
                return back();
            }

            $userChecked = collect($request->users)->filter(fn($user) => isset($user["checked"]));
            // dd($userChecked->isEmpty());
            if ($userChecked->isEmpty()) {
                throw new \Exception("Aucun utilisateur n'a été selectionné");
            }

            if (is_array($request->users) || is_object($request->users)) {
                foreach ($request->users as $val) {

                    if (isset($val["checked"]) && isset($val["checked"]) == "on" && $val["ticket_ids"]) {
                        if ($val["price"] == 0) {
                            continue;
                        }

                        $billing = new Billing();
                        $billing->invoice = $billing->generateRandomNumber();
                        $billing->user_id = $val["user_id"];
                        $billing->price = $val["price"];
                        $billing->save();

                        foreach (json_decode($val["ticket_ids"], true)  as $ticketId) {
                            $ticket = Ticket::find($ticketId);
                            if (!$ticket) {
                                throw new \Exception("Ce ticket n'existe pas!");
                            }

                            /**Attachement du ticket à la facture générée */
                            $ticket->update(["billing_id" => $billing->id]);
                        }
                    }
                }
            }

            DB::commit();
            alert()->success("Opération réussie!", "Facture générée avec succès!");
            return redirect()->route("billing.index"); // redirect('/billing');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure de generation de facture " . $e->getMessage());
            alert()->error("Opération échouée!", "Erreure de generation de facture! " . $e->getMessage());
            return back();
        }
    }
}
