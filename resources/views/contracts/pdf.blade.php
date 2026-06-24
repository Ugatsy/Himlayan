<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contract #{{ $contract->id }}</title>
    <style>
        body { font-family: 'Figtree', sans-serif; font-size: 14px; color: #1f2937; line-height: 1.6; padding: 40px; }
        h1 { font-size: 24px; text-align: center; margin-bottom: 4px; }
        h2 { font-size: 18px; text-align: center; color: #6b7280; font-weight: normal; margin-bottom: 30px; }
        .meta { margin-bottom: 30px; }
        .meta table { width: 100%; }
        .meta td { padding: 4px 0; }
        .meta .label { color: #6b7280; width: 140px; }
        table.details { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.details th, table.details td { border: 1px solid #d1d5db; padding: 8px 12px; text-align: left; }
        table.details th { background: #f3f4f6; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
        .total-row td { font-weight: bold; }
        .signatures { margin-top: 50px; display: flex; justify-content: space-between; }
        .signatures div { width: 45%; }
        .signatures .line { border-top: 1px solid #374151; margin-top: 40px; padding-top: 8px; font-size: 12px; text-align: center; }
        .footer { margin-top: 50px; text-align: center; color: #9ca3af; font-size: 11px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <h1>HIMLAYAN</h1>
    <h2>Contract of Agreement</h2>

    <div class="meta">
        <table>
            <tr><td class="label">Contract #:</td><td>{{ $contract->id }}</td></tr>
            <tr><td class="label">Date:</td><td>{{ $contract->contract_date->format('F d, Y') }}</td></tr>
            <tr><td class="label">Status:</td><td>{{ ucfirst($contract->status) }}</td></tr>
        </table>
    </div>

    <h3 style="margin-bottom: 10px;">Client Information</h3>
    <div class="meta">
        <table>
            <tr><td class="label">Name:</td><td>{{ $contract->client->full_name }}</td></tr>
            <tr><td class="label">Contact:</td><td>{{ $contract->client->contact_number }}</td></tr>
            <tr><td class="label">Email:</td><td>{{ $contract->client->email ?? '—' }}</td></tr>
            <tr><td class="label">Address:</td><td>{{ $contract->client->address ?? '—' }}</td></tr>
            <tr><td class="label">ID Type:</td><td>{{ $contract->client->id_type }} — {{ $contract->client->id_number }}</td></tr>
        </table>
    </div>

    <h3 style="margin-bottom: 10px;">Service Details</h3>
    <div class="meta">
        <table>
            @if($contract->plot)
                <tr><td class="label">Plot/Lot:</td><td>{{ $contract->plot->plot_number }} ({{ $contract->plot->section ?? 'No section' }})</td></tr>
            @endif
            @if($contract->columbaryNiche)
                <tr><td class="label">Columbary Niche:</td><td>{{ $contract->columbaryNiche->niche_number }} ({{ $contract->columbaryNiche->section ?? 'No section' }})</td></tr>
            @endif
            @if($contract->preNeedPlan)
                <tr><td class="label">Pre-Need Plan:</td><td>{{ $contract->preNeedPlan->name }} ({{ ucfirst($contract->preNeedPlan->type) }})</td></tr>
            @endif
            <tr><td class="label">Total Amount:</td><td><strong>₱{{ number_format($contract->total_amount, 2) }}</strong></td></tr>
            <tr><td class="label">Payment Type:</td><td>{{ ucfirst(str_replace('_', ' ', $contract->payment_type)) }}</td></tr>
        </table>
    </div>

    @if($contract->installmentSchedules->count())
        <h3 style="margin-bottom: 10px;">Installment Schedule</h3>
        <table class="details">
            <thead><tr><th>Due Date</th><th>Amount Due</th><th>Amount Paid</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($contract->installmentSchedules as $is)
                    <tr>
                        <td>{{ $is->due_date->format('M d, Y') }}</td>
                        <td>₱{{ number_format($is->amount_due, 2) }}</td>
                        <td>₱{{ number_format($is->amount_paid, 2) }}</td>
                        <td>{{ ucfirst($is->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($contract->payments->count())
        <h3 style="margin-bottom: 10px; margin-top: 20px;">Payment History</h3>
        <table class="details">
            <thead><tr><th>Date</th><th>Amount</th><th>Reference</th><th>Receipt</th></tr></thead>
            <tbody>
                @foreach($contract->payments as $payment)
                    <tr>
                        <td>{{ $payment->paid_at->format('M d, Y') }}</td>
                        <td>₱{{ number_format($payment->amount_paid, 2) }}</td>
                        <td>{{ $payment->reference_number ?? '—' }}</td>
                        <td>{{ $payment->receipt_number ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="signatures">
        <div>
            <div class="line">Client Signature</div>
        </div>
        <div>
            <div class="line">HIMLAYAN Representative</div>
        </div>
    </div>

    <div class="footer">
        HIMLAYAN — Binacao Road, Brgy. Roxas, Solano, Nueva Vizcaya<br>
        This document is computer-generated and valid without a physical signature.
    </div>
</body>
</html>
