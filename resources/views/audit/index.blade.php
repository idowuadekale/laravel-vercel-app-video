@extends('layouts.default')
@section('title', 'Audit Trail')
@section('TopSectionName', 'Audit Trail Overview')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        pre.json-box {
            background: #1e1e1e;
            color: #00ffea;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            max-height: 200px;
            overflow: auto;

            /* ✅ wrap long lines */
            white-space: pre-wrap;
            /* preserve line breaks but allow wrapping */
            word-wrap: break-word;
            /* wrap long words */
            word-break: break-word;
            /* ensures very long words break */
        }

        .badge-created {
            background: #28a745;
            color: #fff;
        }

        .badge-updated {
            background: #ffc107;
            color: #000;
        }

        .badge-deleted {
            background: #dc3545;
            color: #fff;
        }

        .filter-box {
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    @include('includes.topsection')

    <section class="button-area">
        <div class="container box_1170 border-top-generic">
            <h2 class="contact-title mb-3">Audit Trail Logs</h2>

            <!-- Filters -->
            <div class="filter-box row mb-2">
                <div class="col-md-3 mb-1">
                    <select id="filterUser" class="form-control">
                        <option value="">Filter by user</option>
                        @foreach ($users as $user)
                            <option value="{{ $user }}">{{ $user }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-1">
                    <input type="date" id="filterFrom" class="form-control">
                </div>
                <div class="col-md-3 mb-1">
                    <input type="date" id="filterTo" class="form-control">
                </div>
                <div class="col-md-2 mb-1">
                    <button id="clearFilters" class="btn btn-secondary w-100">Clear Filters</button>
                </div>
            </div>

            <table id="auditTable" class="display table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>Changes</th>
                        <th>IP</th>
                        <th>Device</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {

            var table = $('#auditTable').DataTable({
                ajax: '{{ route('audit.json') }}',
                columns: [{
                        data: null,
                        title: "S/N",
                        render: function(data, type, row, meta) {
                            return type === 'export' ? meta.row + 1 : meta.row +
                                1; // ensures S/N in export
                        }
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'action',
                        render: function(data) {
                            if (data === 'created')
                                return '<span class="badge badge-created">Created</span>';
                            if (data === 'updated')
                                return '<span class="badge badge-updated">Updated</span>';
                            if (data === 'deleted')
                                return '<span class="badge badge-deleted">Deleted</span>';
                            return data;
                        }
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: 'model_id'
                    },
                    {
                        data: 'changes',
                        render: function(data) {
                            return '<pre class="json-box">' + JSON.stringify(data, null, 2) +
                                '</pre>';
                        }
                    },
                    {
                        data: 'ip_address'
                    },
                    {
                        data: 'device',
                        render: function(data) {
                            return data.length > 40 ? data.substr(0, 40) + '...' : data;
                        }
                    },
                    {
                        data: 'created_at'
                    }
                ],
                order: [
                    [8, 'desc']
                ], // latest first
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        title: 'Audit Logs',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Audit Logs',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Toggle Columns'
                    }
                ],
                deferRender: true
            });

            // Auto-refresh every 10s
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 10000);

            // Filter by user (simple, case-insensitive)
            $('#filterUser').on('change', function() {
                var val = $(this).val();
                table.column(1).search(val, false, true).draw(); // regex=false, smart=true
            });

            // Filter by date
            $.fn.dataTable.ext.search.push(function(settings, data) {
                var min = $('#filterFrom').val();
                var max = $('#filterTo').val();
                var date = new Date(data[8]);
                if (min && date < new Date(min)) return false;
                if (max && date > new Date(max)) return false;
                return true;
            });
            $('#filterFrom,#filterTo').on('change', function() {
                table.draw();
            });

            // Clear filters
            $('#clearFilters').click(function() {
                $('#filterUser').val('');
                $('#filterFrom').val('');
                $('#filterTo').val('');
                table.search('').columns().search('').draw();
            });

        });
    </script>
@endsection
