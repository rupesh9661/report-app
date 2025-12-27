@if($transactions->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} 
        of {{ number_format($transactions->total()) }} records
    </div>
    <nav>
        {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
    </nav>
</div>
@endif
