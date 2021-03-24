<?php

namespace App\Http\Controllers;

use App\Mail\ReplyMail;
use App\Reply;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Str;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {

        $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|regex:/[0-9]{11}/|min:10',
            'problem_description' => 'required|string|min:1',
        ]);

        $ticket = new Ticket();

        $ticket->ticket_reference_no = rand();
        $ticket->customer_name = $request->input('customer_name');
        $ticket->email = $request->input('email');
        $ticket->phone_number = $request->input('phone_number');
        $ticket->problem_description = $request->input('problem_description');
        $ticket->ticket_status = 'unread';

        $response = $ticket->save();

        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');
    }

    public function getTickets()
    {
        $response = Ticket::with('replies')->orderBy('created_at','desc')->paginate(10);
        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');

    }

    public function searchTicketById(Request $request)
    {
        $response = Ticket::with('replies')->where('ticket_reference_no', $request->input('ticket_reference_no'))->first();
        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');

    }

    public function searchTicketByName(Request $request)
    {
        $response = Ticket::with('replies')->where('customer_name', $request->input('name'))->paginate(10);
        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');

    }

    public function createReply(Request $request)
    {

        $request->validate([
            'reply' => 'required',
        ]);

        $reply = new Reply();
        $reply->ticket_id = $request->input('id');
        $reply->reply = $request->input('reply');

        $response = $reply->save();

        $data = [
            'ticket_reference_no' => $request->input('ticket_reference_no'),
            'name' => $request->input('name'),
            'problem_description' => $request->input('problem_description'),
            'reply' => $request->input('reply'),
        ];

        Mail::to($request->input('email'))->send(new ReplyMail($data));
        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');

    }

    public function updateTicketStatus(Request $request)
    {
        $ticket = Ticket::find($request->input('id'));

        $ticket->ticket_status = 'read';
        $response = $ticket->save();
        return response(['data' => $response, 'status' => 201, 'msg' => 'data loaded successfully'])->header('Content-Type', 'application/json');
    }
}
