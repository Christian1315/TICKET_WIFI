<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Package;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                ->load("user","package"); // Ticket::query()->where('user_id', auth()->id());
        } else {
            $tickets = Ticket::with("user","package")->get(); // Ticket::query()->where('user_id', auth()->id());
        }

        return view('tickets.index', compact("tickets"));
    }

    public function getTicket(Request $request)
    {
        if ($request->isMethod("POST")) {
            $request->validate([
                "number" => "required"
            ]);

            $ticket  = Ticket::firstWhere("number", $request->number);
            if (!$ticket) {
                alert()->error("Opération échouée!", "Ce ticket n'existe pas");
                return back()->withInput();
            }

            if ($ticket->downloaded) {
                alert()->info("Accès réfusé!", "Ce ticket a déjà été télechargé une fois!");
                return back()->withInput();
            }

            /**
             * Update du ticket 
             */
            $ticket->update(["downloaded" => true]);

            alert()->html('<i class="bi bi-check2-circle"></i>', "Ticket #<b>$ticket->number</b> télechargé avec succè!, <a target='_blank' href='{$ticket->ticket_file}'>Voir</a> ", 'success');
            return back()->withInput();
        }
        return view('get_ticket');
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->isUser()) {
            $packages = $user->packages; // 
        } else {
            $packages = Package::with("user")->get();
        }

        return view('tickets.create', compact("packages"));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                "subject" => "required",
                "message" => "required",
                "priority" => "required|in:Elevée,Normale,Faible",
                "package_id" => "required|integer",
                'ticket_file' => ['required', 'file', 'mimes:pdf'],
            ], [
                "subject.required" => "Champ réquis",
                "message.required" => "Champ réquis",

                "priority.required" => "Champ réquis",
                "priority.in" => "La priorité doit être soit Elevée,Normale ou Faible",

                "package_id.required" => "Champ réquis",

                "ticket_file.required" => "Le fichier est est réquis!",
                "ticket_file.file" => "Le fichier n'est pas valide",
                // "ticket_file.file"=>"Le fichier n'est pas valide",
            ]);

            // TRAITEMENT DU DOCUMENT
            $ticket_file = $request->file("ticket_file");
            $ticket_file_name = $ticket_file->getClientOriginalName();
            $ticket_file->move("tickets/", $ticket_file_name);

            $ticket = new Ticket();
            $ticket->subject = $request->subject;
            $ticket->message = $request->message;
            $ticket->priority = $request->priority;
            $ticket->status = 'Open';
            $ticket->user_id = auth()->id();
            $ticket->package_id = $request->package_id;
            $ticket->number = $ticket->generateRandomNumber();
            $ticket->ticket_file = asset("tickets/" . $ticket_file_name);
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
