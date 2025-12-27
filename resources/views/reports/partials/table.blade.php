@if($transactions->count() > 0)
<table class="table table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Transaction Code</th>
            <th>Date</th>
            <th>User</th>
            <th>Provider</th>
            <th>Game</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->transaction_code }}</td>
            <td>{{ date('Y-m-d H:i', strtotime($transaction->transaction_date)) }}</td>
            <td>
                <div><strong>{{ $transaction->user_name }}</strong></div>
                <div class="text-muted small">ID: {{ $transaction->user_id }}</div>
            </td>
            <td>{{ $transaction->provider_name }}</td>
            <td>
                <div>{{ $transaction->game_name }}</div>
                @if($transaction->game_category)
                <div class="text-muted small">{{ ucfirst($transaction->game_category) }}</div>
                @endif
            </td>
            <td class="fw-bold">${{ number_format($transaction->amount, 2) }}</td>
            <td>{{ ucfirst($transaction->type ?? '-') }}</td>
            <td>
                @php
                    $badgeClass = match($transaction->status) {
                        'success' => 'bg-success',
                        'failed' => 'bg-danger',
                        'pending' => 'bg-warning',
                        'cancelled' => 'bg-secondary',
                        default => 'bg-primary'
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="text-center py-5 text-muted">
    <p>No transactions found matching your filters.</p>
</div>
@endif
