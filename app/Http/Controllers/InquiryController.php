<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->get();
        return view('inquiries.index', compact('inquiries'));
    }

    public function create()
    {
        return view('inquiries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'lot_interest'   => 'nullable|string|max:255',
            'message'        => 'nullable|string',
        ]);

        $validated['status'] = 'new';

        Inquiry::create($validated);
        return redirect()->route('inquiries.index')->with('success', 'Inquiry created.');
    }

    public function publicStore(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'lot_interest'   => 'nullable|string|max:255',
            'message'        => 'nullable|string',
        ]);

        $validated['status'] = 'new';

        Inquiry::create($validated);
        return redirect()->back()->with('success', 'Thank you for your inquiry! We will contact you soon.');
    }

    public function show(Inquiry $inquiry)
    {
        return view('inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,closed',
        ]);

        $inquiry->update($validated);
        return redirect()->route('inquiries.index')->with('success', 'Inquiry status updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
