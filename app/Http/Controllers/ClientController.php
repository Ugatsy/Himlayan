<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('full_name')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'required|string',
            'id_number'      => 'required|string|max:100',
            'id_type'        => 'required|string|max:50',
        ]);

        Client::create($validated);
        return redirect()->route('clients.index')->with('success', 'Client created.');
    }

    public function show(Client $client)
    {
        $client->load('contracts.plot', 'contracts.payments');
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'required|string',
            'id_number'      => 'required|string|max:100',
            'id_type'        => 'required|string|max:50',
        ]);

        $client->update($validated);
        return redirect()->route('clients.index')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        if ($client->contracts()->exists()) {
            return back()->with('error', 'Cannot delete client with existing contracts.');
        }
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted.');
    }
}
