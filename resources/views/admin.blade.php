@extends('layouts.app')

@section('title', 'Admin | SIMPTLHP')
@section('page-data', "'basicTables'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: `Admin` }">
            @include('partials.breadcrumb')
        </div>
        <div class="space-y-5 sm:space-y-6">
            <div class="relative border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <div id="tableLoading"
                    class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50 rounded-lg">
                    <div class="flex flex-col items-center gap-2">
                        <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-500 border-t-transparent"></div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            Memuat data...
                        </span>
                    </div>
                </div>
                <table id="userTable" class="display text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Pegawai</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Obrik</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#tableLoading').removeClass('hidden');
                var table = $('#userTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        type: 'POST',
                        url: "{{ url('ajax-data-admin') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'id_pegawai',
                            name: 'id_pegawai',
                            className: 'text-left'
                        },
                        {
                            data: 'nama_pegawai',
                            name: 'nama_pegawai',
                            className: 'text-left'
                        },
                        {
                            data: 'nama_obrik',
                            name: 'nama_obrik',
                            className: 'text-left'
                        },
                        {
                            data: 'level',
                            name: 'level',
                            className: 'text-left'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                table.on('processing.dt', function(e, settings, processing) {
                    if (processing) {
                        $('#tableLoading').removeClass('hidden');
                    } else {
                        $('#tableLoading').addClass('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
