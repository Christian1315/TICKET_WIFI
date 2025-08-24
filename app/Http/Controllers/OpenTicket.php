<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpenTicket extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);

            if (!$ticket) {
                throw new \Exception("Ce ticket n'existe pas");
            }
            $ticket->status = 'Open';
            $ticket->save();

            DB::commit();
            
            alert()->success("Opération réussie!", "Ticket #$ticket->number ouvert avec succès!");
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            alert()->error("Opération échouée!", "Erreure lors de l'ouverture du ticket");
            return
                back();
        }
    }
}
