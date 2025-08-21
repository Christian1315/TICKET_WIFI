<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function create($param)
    {
        if (!auth()->user()->isUser()) {
            $bill = Billing::find($param);

            if (!$bill) {
                alert()->error("Opération échouée!", "Cette facture n'existe pas!");
                return back();
            }
            return view('payments.create', compact('bill'));
        }

        alert()->error("Opération échouée!", "Vous n'êtes pas autorisé.e à éffectuer cette opération");
        return redirect()->back();
    }

    public function store(Request $request)
    {
        try {
            $bill = Billing::firstWhere('invoice', $request->invoice);

            DB::beginTransaction();
            $payment = new Payment();
            $payment->user_id = $bill->user_id;
            $payment->billing_id = $bill->id;
            $payment->invoice = $bill->invoice;
            $payment->package_price = $bill->package_price;
            $payment->payment_method = $request->payment_method;
            $payment->save();

            DB::commit();
            alert()->success("Opération réussie!", "Paiement éffectué avec succès!");

            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure survenue lors du payement de la facture : REF_" . $bill->invoice);
            return back()->withInput();
        }
    }

    /**
     * Traitement de la facture après
     * transaction éffectuée
     */
    public function handlePayementAfterProcess(Request $request, $bill)
    {
        try {
            $bill = Billing::find($bill);

            if (!$bill) {
                throw new \Exception("Cette facture n'existe pas");
            }

            if (!$request->transaction_id) {
                throw new \Exception("Transaction échouée! Veuillez éessayer ultérieurement!");
            }

            DB::beginTransaction();
            $payment = new Payment();
            $payment->user_id = $bill->user_id;
            $payment->billing_id = $bill->id;
            $payment->invoice = $bill->invoice;
            $payment->package_price = $bill->package_price;
            $payment->payment_method = 'Kkiapay'; // $request->payment_method;
            $payment->save();


            Log::debug("Transaction ID de la facture REF_$bill->invoice : ($request->transaction_id)");

            DB::commit();
            alert()->success("Opération réussie!", "Paiement éffectué avec succès!");
            // retour à l'édition du user
            return redirect()->route("users.show", $bill->user_id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure survenue lors du payement de la facture : REF_$bill->invoice : " . $e->getMessage());
            alert()->error("Opération échouée!", "Erreure survenue lors du payement de la facture : REF_" . $bill->invoice);
            return back()->withInput();
        }
    }

    public function process(Request $request)
    {
        try {

            DB::beginTransaction();

            $user = $request->user();
            $dollar_to_cent = $request->amount;

            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($request->payment_method);

            $user->charge($dollar_to_cent, $request->payment_method);

            // Handle successful payment
            $bill = Billing::find($request->bill);

            if (!$bill) {
                throw new \Exception("Cette facture ( REF_$bill->invoice) n'existe pas");
            }

            $payment = new Payment();
            $payment->user_id = $bill->user_id;
            $payment->billing_id = $bill->id;
            $payment->invoice = $bill->invoice;
            $payment->package_price = $bill->package_price;
            $payment->payment_method = 'Stripe';
            $payment->save();

            DB::commit();
            alert()->success("Opération réussie!", "Processus de paiement éffectué avec succès!");
            return redirect('payment'); //->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error("Opération échouée!", "Erreure survenue lors du processus de payement de la facture " . $e->getMessage());
            return back()->withInput();
        }
    }
}
