<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Ticket;
use App\Role;
use App\Status;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Ticket $ticket) {
        return $user->is($ticket->submitting_user) || $user->role->name == Role::EERSTELIJNS_MEDEWERKER || $user->role->name == Role::TWEEDELIJNS_MEDEWERKER;
    }

    public function create(User $user) {
        return $user->role->name == Role::KLANT;
    }

    public function assign(User $user) {
        return $user->role->name == Role::EERSTELIJNS_MEDEWERKER || $user->role->name == Role::TWEEDELIJNS_MEDEWERKER;
    }

    public function comment(User $user, Ticket $ticket) {
        return ($user->is($ticket->submitting_user) || $user->assigned_tickets->contains($ticket)) && $ticket->isOpen();
    }

    public function close(User $user, Ticket $ticket) {
        return $ticket->isOpen() &&
            ($user->is($ticket->submitting_user) ||
            $user->assigned_tickets->contains($ticket));
    }

    public function claim(User $user, Ticket $ticket) {
        return (
            $user->role->name == Role::EERSTELIJNS_MEDEWERKER && $ticket->status->name == Status::EERSTELIJNS_WACHT
            ) || (
            $user->role->name == Role::TWEEDELIJNS_MEDEWERKER && $ticket->status->name == Status::TWEEDELIJNS_WACHT);
    }

    public function free(User $user, Ticket $ticket) {
        return
            $user->assigned_tickets->contains($ticket) && (
            $user->role->name == Role::EERSTELIJNS_MEDEWERKER && $ticket->status->name == Status::EERSTELIJNS_TOEGEWEZEN
            ) || (
            $user->role->name == Role::TWEEDELIJNS_MEDEWERKER && $ticket->status->name == Status::TWEEDELIJNS_TOEGEWEZEN);
    }

    public function escalate(User $user, Ticket $ticket) {
       return $user->assigned_tickets->contains($ticket) && (
           $user->role->name == Role::EERSTELIJNS_MEDEWERKER && $ticket->status->name == Status::EERSTELIJNS_TOEGEWEZEN);
    }

    public function deescalate(User $user, Ticket $ticket) {
        return $user->assigned_tickets->contains($ticket) && (
            $user->role->name == Role::TWEEDELIJNS_MEDEWERKER && $ticket->status->name == Status::TWEEDELIJNS_TOEGEWEZEN);
    }

    public function delegate(User $user, Ticket $ticket) {
        return
            $user->assigned_tickets->contains($ticket) && (
                $user->role->users->count() > 1
            );
    }
}
