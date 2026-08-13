@extends('layouts.app')

@section('title', 'Approval Tindak Lanjut SSR | SIMPTLHP')
@section('page-data', "'verifikasi-ssr'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Verifikasi SSR
                        </h3>
                        <p class="text-sm text-gray-500">
                            Approval Tindak Lanjut SSR
                        </p>
                    </div>
                </div>

                {{-- TOOLBAR --}}
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    {{-- SHOW --}}
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Tampilkan</span>
                        <select id="pageLength"
                            class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    {{-- SEARCH --}}
                    <div class="relative">
                        <input id="customSearch" type="text" placeholder="Cari tindak lanjut..."
                            class="h-10 w-72 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                {{-- Loading --}}
                <div id="tableLoading"
                    class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Loading...</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="verifikasiSsrTable" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Tanggal Tindak
                                    Lanjut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Tindak Lanjut
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Rincian Temuan
                                    Keuangan Pajak</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Rincian Temuan
                                    Keuangan Daerah</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Rincian Temuan
                                    Keuangan Desa</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Rincian Temuan
                                    Keuangan BLUD</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Status Tindak
                                    Lanjut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Keterangan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Log</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div
                    class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div id="tableInfo" class="text-sm text-gray-500"></div>
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

                const SPINNER_HTML = `
                        <svg aria-hidden="true" class="w-5 h-5 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>`;

                $('#verifikasiSsrTable').on('processing.dt', function(e, settings, processing) {
                    $('#tableLoading').toggleClass('hidden', !processing);
                });

                var dataTable = $('#verifikasiSsrTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    dom: 'rtip',
                    searching: true,
                    ordering: true,
                    lengthChange: false,
                    ajax: {
                        type: 'POST',
                        url: "{{ url('ajax-data-verifikasi-ssr') }}"
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'tgl_tindak_lanjut',
                            name: 'tgl_tindak_lanjut',
                            className: 'text-center'
                        },
                        {
                            data: 'tindak_lanjut',
                            name: 'tindak_lanjut',
                            className: 'text-center'
                        },
                        {
                            data: 'rincian_keuangan',
                            name: 'rincian_keuangan',
                            className: 'text-center'
                        },
                        {
                            data: 'rincian_keuangan2',
                            name: 'rincian_keuangan2',
                            className: 'text-center'
                        },
                        {
                            data: 'rincian_keuangan3',
                            name: 'rincian_keuangan3',
                            className: 'text-center'
                        },
                        {
                            data: 'rincian_keuangan4',
                            name: 'rincian_keuangan4',
                            className: 'text-center'
                        },
                        {
                            data: 'id_status',
                            name: 'id_status',
                            className: 'text-center'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
                            className: 'text-center'
                        },
                        {
                            data: 'log',
                            name: 'log',
                            className: 'text-center'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        processing: "",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
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

                function moveDataTableFooter() {
                    $('#verifikasiSsrTable_info').appendTo('#tableInfo');
                    $('#verifikasiSsrTable_paginate').appendTo('#tablePagination');
                }

                dataTable.on('init.dt', moveDataTableFooter);
                dataTable.on('draw.dt', moveDataTableFooter);
            });
        </script>
    @endpush
@endsection
