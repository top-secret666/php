<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with(['performance','seat'])->paginate(30);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
