<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Status;
use App\Ticket;
use App\Role;
use App\User;

class TicketController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Deze method moet een view retourneren met een formulier om een ticket te maken. Naam voor de view bijv.: ticket/create.blade.php
     */
    public function create() {
        $this->authorize('create', Ticket::class);

        return view('ticket.create');
    }

    /**
     * Deze method moet de gegevens uit de request valideren en dan afhankelijk daarvan:
     *   -	redirecten naar ticket_create (met foutmeldingen)
     *   -	ticket bewaren, en redirecten naar ticket_index (met succesmelding)
     */
    public function save(Request $request) {
        $this->authorize('create', Ticket::class);

        $request->validate(
            [
                'title' => 'required|max:191',
                'description' => 'required'
            ]
        );

        $status = Status::where('name', Status::EERSTELIJNS_WACHT)->first();

        $ticket = new Ticket();

        $ticket->title = $request->title;
        $ticket->description = $request->description;

        $ticket->status()->associate($status);
        $request->user()->submitted_tickets()->save($ticket);

        return redirect()->route('ticket_index_customer')->with('success', 'Your ticket is saved...');
    }

    /**
     * Deze method moet alle tickets van de authenticated user ophalen, en een view retourneren met die tickets.
     * Naam voor de view bijv.: ticket/index.blade.php
     */
    public function index() {
        $this->authorize('create', Ticket::class);

        $tickets = Auth::user()->submitted_tickets()->orderBy('created_at', 'DESC')->get();

        return view('ticket.index_customer', ['tickets' => $tickets]);
    }

    /**
     * Deze method moet het ticket met id $id ophalen, samen met alle comments erop, en een view retourneren met dat ticket en de comments.
     * Naam voor de view bijv.: ticket/show.blade.php
     */
    public function show($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('show', $ticket);

        $vars = [];

        $vars['ticket'] = $ticket;

        if (Auth::user()->can('delegate', $ticket)) {

            $vars['users'] = Auth::User()->role->users->diff([Auth::User()]);

        }

        return view('ticket.show', $vars);
    }

    public function index_helpdesk() {
        $this->authorize('assign', Ticket::class);

        $assigned_tickets = Auth::user()->assigned_tickets;

        if (Auth::user()->role->name == Role::EERSTELIJNS_MEDEWERKER) {

            $status = Status::where('name', Status::EERSTELIJNS_WACHT)->first();

        } else if (Auth::user()->role->name == Role::TWEEDELIJNS_MEDEWERKER) {

            $status = Status::where('name', Status::TWEEDELIJNS_WACHT)->first();

        }

        $unassigned_tickets = $status->tickets;

        return view (
            'ticket.index_helpdesk',
            [
                'assigned_tickets' => $assigned_tickets,
                'unassigned_tickets' => $unassigned_tickets
            ]
            );
    }

    public function close($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('close', $ticket);

        $status = Status::where('name', Status::AFGEHANDELD)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        return redirect()->back()->with('success', 'Ticket is closed...');
    }

    public function claim($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('claim', $ticket);

        if ($ticket->status->name == Status::EERSTELIJNS_WACHT) {

            $status = Status::where('name', Status::EERSTELIJNS_TOEGEWEZEN)->first();

        } else if ($ticket->status->name == Status::TWEEDELIJNS_WACHT) {

            $status = Status::where('name', Status::TWEEDELIJNS_TOEGEWEZEN)->first();

        }

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::User()->assigned_tickets()->attach($ticket);

        return redirect()->back()->with('success', 'Ticket is claimed...');
    }

    public function free($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('free', $ticket);

        if ($ticket->status->name == Status::EERSTELIJNS_TOEGEWEZEN) {

            $status = Status::where('name', Status::EERSTELIJNS_WACHT)->first();

        } else if ($ticket->status->name == Status::TWEEDELIJNS_TOEGEWEZEN) {

            $status = Status::where('name', Status::TWEEDELIJNS_WACHT)->first();

        }

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::User()->assigned_tickets()->detach($ticket);

        return redirect()->back()->with('success', 'Ticket is available...');
    }

    public function escalate($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('escalate', $ticket);

        $status = Status::where('name', Status::TWEEDELIJNS_WACHT)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        return redirect()->route('ticket_index_helpdesk')->with('success', 'Ticket is escalated...');
    }

    public function deescalate($id) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('deescalate', $ticket);

        $status = Status::where('name', Status::EERSTELIJNS_TOEGEWEZEN)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::user()->assigned_tickets()->detach($ticket);

        return redirect()->route('ticket_index_helpdesk')->with('success', 'Ticket is deëscalated...');
    }

    public function delegate($id, Request $request) {
        $ticket = Ticket::findOrFail($id);

        $this->authorize('delegate', $ticket);

        $request->validate(
            [
                'colleague_id' => 'exists:users,id'
            ]
        );

        $delegated_user = User::find($request->colleague_id);

        if (Auth::User()->is($delegated_user) || Auth::User()->role->isNot($delegated_user->role)) {
            return redirect()->back()->with('error_delegate', 'Invalid request!!');
        }

        Auth::User()->assigned_tickets()->detach($ticket);

        $delegated_user->assigned_tickets()->attach($ticket);

        return redirect()->back()->with('success', 'Ticket is delegated to ' . $delegated_user->name . '.');
    }
}
