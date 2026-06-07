<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('contract.client', 'contract.plot')
            ->orderBy('paid_at', 'desc')
            ->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $contracts = Contract::with('client', 'plot')->where('status', 'active')->get();
        return view('payments.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_id'     => 'required|exists:contracts,id',
            'amount_paid'     => 'required|numeric|min:0.01',
            'payment_type'    => 'required|in:cash,credit_card,installment',
            'reference_number' => 'nullable|string|max:100',
            'receipt_number'  => 'nullable|string|max:50',
            'notes'           => 'nullable|string|max:500',
            'paid_at'         => 'required|date',
        ]);

        $validated['paid_at'] = $validated['paid_at'] ?? now();
        $validated['receipt_number'] = $validated['receipt_number'] ?? 'RCP-' . strtoupper(uniqid());

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment recorded.');
    }

    public function show(Payment $payment)
    {
        $payment->load('contract.client', 'contract.plot');
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}
