<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isUser()) {
            $tickets = $user->tickets
                ->load("user"); // Ticket::query()->where('user_id', auth()->id());
        } else {
            $tickets = Ticket::with("user")->get(); // Ticket::query()->where('user_id', auth()->id());
        }

        return view('tickets.index', compact("tickets"));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                "subject" => "required",
                "message" => "required",
                "priority" => "required|in:Elevée,Normale,Faible",
            ], [
                "subject.required" => "Champ réquis",
                "message.required" => "Champ réquis",

                "priority.required" => "Champ réquis",
                "priority.in" => "La priorité doit être soit Elevée,Normale ou Faible",

            ]);

            $ticket = new Ticket();
            $ticket->subject = $request->subject;
            $ticket->message = $request->message;
            $ticket->priority = $request->priority;
            $ticket->status = 'Open';
            $ticket->user_id = auth()->id();
            $ticket->number = $ticket->generateRandomNumber();
            $ticket->save();

            DB::commit();
            alert()->success("Opération réussie!", "Ticket géneré avec succès!");
            return redirect()->route("ticket.index"); // redirect('ticket');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::debug("Erreure de validation", ["errors" => $e->errors()]);

            alert()->error("Opération échouée!", "Erreure de validation");
            return back()->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("Erreure lors de la création de ticket : " . $e->getMessage());

            alert()->error("Opération échouée!", "Erreure lors de la création de ticket");
            return back()->withInput();
        }
    }

    public function show(Ticket $ticket)
    {
        $comments = Comment::where('ticket_id', $ticket->id)->with('user')->get();
        return view('tickets.show', compact('ticket', 'comments'));
    }
}
