<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class InvoiceDownload extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $invoice = Payment::with('billing')->find($id);

        if (!$invoice) {
            alert()->info("Opération bloquée!", "Cette facture n'existe pas!");
            return redirect()->back(); //->with('error', 'Insert ISP information first');
        }

        if (Company::doesntExist()) {
            alert()->info("Opération bloquée!", "L'entreprise FAI n'existe pas encore! Veuillez la configurer!");
            return redirect()->back(); //->with('error', 'Insert ISP information first');
        }

        $company = Company::firstOrFail();
        $pdf = PDF::loadview('reports.invoice', compact('invoice', 'company'));
        return $pdf->download(config('app.name') . ' Invoice ' . date('dmY') . ('.pdf'));
    }
}
