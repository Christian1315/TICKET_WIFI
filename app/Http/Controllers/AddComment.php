<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddComment extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();

            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->user_id = auth()->id();
            $comment->ticket_id = $request->ticket_id;
            $comment->save();

            $comment->refresh();

            DB::commit();
            alert()->success("Opération réussie!", "Ticket #{{$comment->ticket->number}} ouvert avec succès!");
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            alert()->error("Opération échouée!", "Erreure lors du commentaire");
            return
                back();
        }
    }
}
