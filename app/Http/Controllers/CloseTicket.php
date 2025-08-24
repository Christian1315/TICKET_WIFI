<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseTicket extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);

            if (!$ticket) {
                throw new \Exception("Ce ticket n'existe pas");
            }
            
            $ticket->status = 'Close';
            $ticket->save();

            alert()->success("Opération réussie!", "Ticket #$ticket->number fermé avec succès!");
            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug("Erreure lors de la fermeture du ticket : " . $e->getMessage());

            alert()->error("Opération échouée!", "Erreure lors de la fermeture du ticket");
            return
                back();
        }
    }
}
