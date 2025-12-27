<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="mb-4">Transaction Report</h1>

                <!-- Filter Section -->
                <form id="filterForm">
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Date From</label>
                                    <input type="date" class="form-control" name="date_from" id="date_from">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Date To</label>
                                    <input type="date" class="form-control" name="date_to" id="date_to">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="">All Statuses</option>
                                        @foreach($filterOptions['statuses'] as $status)
                                            <option value="{{ $status->status }}">
                                                {{ ucfirst($status->status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">User</label>
                                    <select class="form-select ajax-select" id="user_id" name="user_id" data-placeholder="Type to search users...">
                                        <option value="">All Users</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Provider</label>
                                    <select class="form-select ajax-select" id="provider_id" name="provider_id" data-placeholder="Type to search providers...">
                                        <option value="">All Providers</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Game</label>
                                    <select class="form-select ajax-select" id="game_id" name="game_id" data-placeholder="Type to search games...">
                                        <option value="">All Games</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Amount Min</label>
                                    <input type="number" step="0.01" class="form-control" name="amount_min" id="amount_min" placeholder="Min">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Amount Max</label>
                                    <input type="number" step="0.01" class="form-control" name="amount_max" id="amount_max" placeholder="Max">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-success" id="applyFilter">Apply Filters</button>
                                <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Report Table -->
                <div class="table-responsive">
                    <table id="transactionsTable" class="table table-hover table-striped">
                        <thead class="table-primary">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#transactionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("reports.data") }}',
                    type: 'GET',
                    data: function(d) {
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.status = $('#status').val();
                        d.user_id = $('#user_id').val();
                        d.provider_id = $('#provider_id').val();
                        d.game_id = $('#game_id').val();
                        d.amount_min = $('#amount_min').val();
                        d.amount_max = $('#amount_max').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'transaction_code', name: 'transaction_code' },
                    { 
                        data: 'transaction_date', 
                        name: 'transaction_date'
                    },
                    { 
                        data: 'user_name',
                        name: 'user_name'
                    },
                    { data: 'provider_name', name: 'provider_name' },
                    { 
                        data: 'game_name',
                        name: 'game_name'
                    },
                    { 
                        data: 'amount',
                        name: 'amount',
                        render: function(data) {
                            return '<span class="fw-bold">$' + parseFloat(data).toFixed(2) + '</span>';
                        }
                    },
                    { 
                        data: 'type',
                        name: 'type',
                        render: function(data) {
                            return data ? data.charAt(0).toUpperCase() + data.slice(1) : '-';
                        }
                    },
                    { 
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            var badgeClass = 'bg-primary';
                            switch(data) {
                                case 'success': badgeClass = 'bg-success'; break;
                                case 'failed': badgeClass = 'bg-danger'; break;
                                case 'pending': badgeClass = 'bg-warning'; break;
                                case 'cancelled': badgeClass = 'bg-secondary'; break;
                            }
                            return '<span class="badge ' + badgeClass + '">' + 
                                   data.charAt(0).toUpperCase() + data.slice(1) + 
                                   '</span>';
                        }
                    }
                ],
                pageLength: 20,
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                order: [[2, 'desc']],
            });

            // Apply Filters button
            $('#applyFilter').on('click', function() {
                table.draw();
            });

            // Reset button
            $('#resetBtn').on('click', function() {
                $('#filterForm')[0].reset();
                $('#user_id, #provider_id, #game_id').val(null).trigger('change');
                table.draw();
            });

            // Initialize Select2 for User dropdown
            $('#user_id').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: '/filters/search-users',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                placeholder: 'Type to search users...',
                allowClear: true
            });

            // Initialize Select2 for Provider dropdown
            $('#provider_id').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: '/filters/search-providers',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                placeholder: 'Type to search providers...',
                allowClear: true
            });

            // Initialize Select2 for Game dropdown
            $('#game_id').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: '/filters/search-games',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                placeholder: 'Type to search games...',
                allowClear: true
            });
        });
    </script>
</body>
</html>
