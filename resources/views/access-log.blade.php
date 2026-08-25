@extends('layouts.app')

@section('title', 'Riwayat Login | SIMPTLHP')
@section('page-data', "'basicTables'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">

            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                {{-- HEADER --}}
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Riwayat Login
                        </h3>

                        <p class="text-sm text-gray-500">
                            Riwayat akses login pengguna
                        </p>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5
                    lg:flex-row lg:items-end lg:justify-between
                    dark:border-gray-800">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end">

                        {{-- SHOW --}}
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">
                                Tampilkan
                            </span>

                            <select id="pageLength"
                                class="h-10 rounded-lg border border-gray-300
                                bg-transparent px-3 py-2 text-sm text-gray-800
                                outline-none focus:border-brand-500 focus:ring-0
                                dark:border-gray-700 dark:bg-gray-900
                                dark:text-white">

                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>

                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Dari tanggal
                            </label>
                            <input type="text" id="startDate"
                                class="datepickerKasus h-10 rounded-lg border border-gray-300 bg-transparent
                                px-3 py-2 text-sm text-gray-800 outline-none
                                focus:border-brand-500 focus:ring-0
                                dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Sampai tanggal
                            </label>
                            <input type="text" id="endDate"
                                class="datepickerKasus h-10 rounded-lg border border-gray-300 bg-transparent
                                px-3 py-2 text-sm text-gray-800 outline-none
                                focus:border-brand-500 focus:ring-0
                                dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>

                        <button type="button" id="btnFilter"
                            class="h-10 rounded-lg bg-brand-500 px-5 py-2.5
                            text-sm font-medium text-white
                            hover:bg-brand-600">
                            Filter
                        </button>

                        <button type="button" id="btnResetFilter"
                            class="h-10 rounded-lg border border-gray-300
                            bg-white px-5 py-2.5 text-sm font-medium
                            text-gray-700 hover:bg-gray-50
                            dark:border-gray-700 dark:bg-gray-800
                            dark:text-gray-400 dark:hover:bg-white/[0.03]">
                            Reset
                        </button>
                    </div>
                </div>
                <div id="tableLoading"
                    class="hidden absolute inset-0 z-50 flex items-center
                    justify-center bg-white/70 dark:bg-gray-900/70">
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="h-10 w-10 animate-spin rounded-full
                            border-4 border-blue-500 border-t-transparent">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            Loading...
                        </span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    No
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Nama Pegawai
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Kode Unor
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Level
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Login
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Logout
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Browser
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Platform
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs
                                    font-semibold uppercase text-gray-500">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>
                    </table>
                </div>
                <div
                    class="flex flex-col gap-4 border-t border-gray-200
                    px-6 py-5 md:flex-row md:items-center
                    md:justify-between dark:border-gray-800">
                    <div id="tableInfo" class="text-sm text-gray-500">
                    </div>
                    <div id="tablePagination"></div>
                </div>
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
                const URL = {
                    ajaxAccessLog: "{{ route('access-log.ajax') }}"
                };
                $('#dataTable').on(
                    'processing.dt',
                    function(e, settings, processing) {
                        $('#tableLoading')
                            .toggleClass('hidden', !processing);
                    }
                );
                const dataTable = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    dom: 'rtip',
                    searching: true,
                    ordering: true,
                    lengthChange: false,
                    order: [
                        [4, 'desc']
                    ],
                    ajax: {
                        type: 'POST',
                        url: URL.ajaxAccessLog,
                        data: function(d) {
                            d.start_date = $('#startDate').val();
                            d.end_date = $('#endDate').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'nama_pegawai',
                            name: 'pegawai.nama_pegawai',
                            className: 'text-left whitespace-nowrap'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
                            className: 'text-center whitespace-nowrap'
                        },
                        {
                            data: 'level',
                            name: 'level',
                            className: 'text-center'
                        },
                        {
                            data: 'login_at',
                            name: 'login_at',
                            className: 'text-center whitespace-nowrap'
                        },
                        {
                            data: 'logout_at',
                            name: 'logout_at',
                            className: 'text-center whitespace-nowrap'
                        },
                        {
                            data: 'browser',
                            name: 'browser',
                            className: 'text-center whitespace-nowrap'
                        },
                        {
                            data: 'platform',
                            name: 'platform',
                            className: 'text-center whitespace-nowrap'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false,
                            className: 'text-center whitespace-nowrap'
                        }
                    ],
                    language: {
                        processing: "",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        infoFiltered: "",
                        paginate: {
                            previous: "←",
                            next: "→"
                        }
                    }
                });
                $('#customSearch').on('input', function() {
                    dataTable.search(this.value).draw();
                });
                $('#pageLength').on('change', function() {
                    dataTable.page.len(this.value).draw();
                });
                $('#btnFilter').on('click', function() {
                    const startDate = $('#startDate').val();
                    const endDate = $('#endDate').val();
                    if ((startDate && !endDate) || (!startDate && endDate)) {
                        Swal.fire({
                            title: 'Perhatian',
                            text: 'Tanggal mulai dan tanggal akhir harus diisi.',
                            icon: 'warning'
                        });
                        return;
                    }
                    if (startDate && endDate && startDate > endDate) {
                        Swal.fire({
                            title: 'Perhatian',
                            text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.',
                            icon: 'warning'
                        });
                        return;
                    }
                    dataTable
                        .ajax
                        .reload();
                });
                $('#btnResetFilter').on('click', function() {
                    $('#startDate').val('');
                    $('#endDate').val('');
                    dataTable
                        .ajax
                        .reload();
                });
                $('#startDate, #endDate').on('keypress', function(e) {
                    if (e.which === 13) {
                        $('#btnFilter').trigger('click');
                    }
                });

                function moveDataTableFooter() {
                    $('#dataTable_info')
                        .appendTo('#tableInfo');
                    $('#dataTable_paginate')
                        .appendTo('#tablePagination');
                }
                dataTable.on(
                    'init.dt',
                    moveDataTableFooter
                );
                dataTable.on(
                    'draw.dt',
                    moveDataTableFooter
                );
            });
        </script>
    @endpush
@endsection
