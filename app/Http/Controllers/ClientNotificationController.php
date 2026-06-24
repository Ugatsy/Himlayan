<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\BurialPermit;
use App\Models\SentClientNotification;
use App\Notifications\BurialPermitIssued;
use App\Notifications\ContractApproved;
use App\Notifications\BurialScheduled;
use Illuminate\Http\Request;

class ClientNotificationController extends Controller
{
    public function index()
    {
        $notifications = SentClientNotification::with('client')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('client-notifications.index', compact('notifications'));
    }

    public function sendManual(Request $request)
    {
        $validated = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'subject'      => 'required|string|max:255',
            'body'         => 'required|string|max:2000',
            'channel'      => 'required|in:database,mail',
        ]);

        $client = Client::findOrFail($validated['client_id']);

        SentClientNotification::create([
            'client_id' => $client->id,
            'type'      => 'manual',
            'channel'   => $validated['channel'],
            'subject'   => $validated['subject'],
            'body'      => $validated['body'],
            'status'    => 'sent',
        ]);

        return back()->with('success', 'Notification sent to ' . $client->full_name . '.');
    }
}
