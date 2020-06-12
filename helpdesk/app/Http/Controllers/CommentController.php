<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Comment;
use Validator;

class CommentController extends Controller
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
     * Deze method moet de gegevens uit de request valideren en afhankelijk daarvan:
     *  -   redirecten naar ticket_show (met foutmeldingen)
     *  -	comment bewaren in de database en redirecten naar ticket_show (met succesmelding)
     *  @todo policy toevoegen.
     */
    public function save(Request $request, $ticket_id) {
        $ticket = Ticket::findOrFail($ticket_id);

        $this->authorize('comment', $ticket);

        $validator = Validator::make (
            $request->all(),
            [
                'contents' => 'required'
            ]
            );

            if ($validator->fails()) {
                return redirect()->route('ticket_show', ['id' => $ticket, '#form'])->withErrors($validator)->withInput();
            }

        $comment = new Comment;
        $comment->contents = $request->contents;
        $comment->ticket()->associate($ticket);

        $request->user()->comments()->save($comment);

        return redirect()->route('ticket_show', ['id' => $ticket, '#comments'])->with('success', 'Comment successfully sent');
    }
}
