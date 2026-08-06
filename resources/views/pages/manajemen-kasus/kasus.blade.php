@extends('layouts.app')

@section('title', 'Manajemen Daftar Kasus | SIMPTLHP')
@section('page-data', "'daftar-kasus'")

@section('content')
    <div id="sectionKasus">
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div class="space-y-6">
                <div
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                Daftar Kasus
                            </h3>
                            <p class="text-sm text-gray-500">
                                Kelola seluruh daftar kasus
                            </p>
                        </div>
                        <button id="openModalBtn"
                            class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                            + Tambah Kasus
                        </button>
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
                            <input id="customSearch" type="text" placeholder="Cari tahun pemeriksaan..."
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
                        <table id="dataTable" class="min-w-full text-sm dt-table">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Temuan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Tahun
                                        Pemeriksaan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">NO. & TGL
                                        SURAT TUGAS</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nomor LHP
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Tanggal
                                        LHP
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama Obrik
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">Aksi
                                    </th>
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
        <!-- Modal -->
        <div id="modalKasus"
            class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
            <div id="modalContent"
                class="relative w-full max-w-[800px] rounded-3xl bg-white p-6 
            transform scale-95 transition-transform duration-300
            dark:bg-gray-900 lg:p-10">
                <button id="closeModalBtn"
                    class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                            fill="" />
                    </svg>
                </button>
                <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 pt-3 pb-3 border-b border-gray-200">
                        <h3 class="modal-header text-base font-medium text-gray-800 dark:text-white/90"></h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                        <form id="formKasus">
                            <div class="-mx-2.5 flex flex-wrap gap-y-5">
                                <input type="hidden" id="id" name="id">
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Nama Obrik <span class="text-red-400">*</span>
                                            </label>
                                            <select name="kode_unor" id="kode_unor" data-placeholder="Pilih OPD"
                                                class="opd h-11 w-full rounded-lg border border-gray-300 text-sm">
                                                <option value="" disabled selected
                                                    class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih OPD
                                                </option>
                                                @foreach ($obriks as $obrik)
                                                    <option value="{{ $obrik->kode_instansi }}"
                                                        class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ ucwords(strtolower($obrik->nama_instansi)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="err text-theme-xs text-error-500" id="kode_unor_error"></p>
                                        </div>
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Tahun Pemeriksaan <span class="text-red-400">*</span>
                                            </label>
                                            <select name="tahun_pemeriksaan" id="tahun_pemeriksaan"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option selected disabled value=""
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                    Pilih tahun
                                                </option>
                                                @for ($i = 2005; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <p class="err text-theme-xs text-error-500" id="tahun_pemeriksaan_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Nomor LHP <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="nomor_lhp" id="nomor_lhp" placeholder="No. LHP"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            <p class="err text-theme-xs text-error-500" id="nomor_lhp_error"></p>
                                        </div>
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Ketua Tim <span class="text-red-400">*</span>
                                            </label>
                                            <select name="nip_ketua" id="nip_ketua" data-placeholder="Pilih Ketua Tim"
                                                class="opd h-11 w-full rounded-lg border border-gray-300 text-sm">
                                                <option value="" selected disabled
                                                    class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                </option>
                                                @foreach ($ketua_tims as $ketua_tim)
                                                    <option value="{{ $ketua_tim->nip_baru }}"
                                                        class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ ucwords(strtolower($ketua_tim->nama_pegawai)) }} -
                                                        {{ $ketua_tim->nip_baru }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="err text-theme-xs text-error-500" id="nip_ketua_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <!-- Nomor SPT -->
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                No. SPT <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="nomor_spt" id="nomor_spt"
                                                placeholder="No. Surat Tugas"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            <p class="err text-theme-xs text-error-500" id="nomor_spt_error"></p>
                                        </div>
                                        <!-- Tanggal SPT -->
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Tgl. SPT <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="tanggal_spt" id="tanggal_spt"
                                                placeholder="Pilih tanggal SPT"
                                                class="datepickerKasus dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                            <p class="err text-theme-xs text-error-500" id="tanggal_spt_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <!-- Nomor SPT -->
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                SPT Mulai <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="spt_mulai" id="spt_mulai"
                                                placeholder="Mulai Pemeriksaan"
                                                class="datepickerKasus dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            <p class="err text-theme-xs text-error-500" id="spt_mulai_error"></p>
                                        </div>

                                        <!-- Nomor SPT -->
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                SPT Selesai <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="spt_selesai" id="spt_selesai"
                                                placeholder="Selesai Pemeriksaan"
                                                class="datepickerKasus dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            <p class="err text-theme-xs text-error-500" id="spt_selesai_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Jenis PHP <span class="text-red-400">*</span>
                                            </label>
                                            <select name="id_jenis_php" id="id_jenis_php"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option value="" selected disabled
                                                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                    Jenis PHP
                                                </option>
                                                @foreach ($jenisPhp as $item)
                                                    <option value="{{ $item->id_jenis_php }}"
                                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $item->jenis_php }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="err text-theme-xs text-error-500" id="id_jenis_php_error"></p>
                                        </div>
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Tanggal LHP <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="tanggal_lhp" id="tanggal_lhp"
                                                placeholder="Tanggal LHP"
                                                class="datepickerKasus dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                            <p class="err text-theme-xs text-error-500" id="tanggal_lhp_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5">
                                    <div class="mt-1 flex items-center gap-3">
                                        <button type="submit" id="btn-save"
                                            class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                                            Simpan
                                        </button>
                                        <button type="button"
                                            class="cancel flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.manajemen-kasus.partials.temuan-tab')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const URL = {
                    ajaxKasus: "{{ url('ajax-data-daftar-kasus') }}",
                    storeKasus: "{{ url('daftar-kasus') }}",
                };

                const SPINNER_HTML = `
                        <svg aria-hidden="true" class="w-5 h-5 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>`;


                $('#dataTable')
                    .on('processing.dt', function(e, settings, processing) {
                        $('#tableLoading').toggleClass('hidden', !processing);
                    });

                const dataTable = $('#dataTable').DataTable({
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
                        url: URL.ajaxKasus
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'id_jenis_php',
                            name: 'id_jenis_php',
                            className: 'text-center'
                        },
                        {
                            data: 'tahun_pemeriksaan',
                            name: 'tahun_pemeriksaan',
                            className: 'text-center'
                        },
                        {
                            data: 'spt',
                            name: 'spt',
                            className: 'text-center'
                        },
                        {
                            data: 'nomor_lhp',
                            name: 'nomor_lhp',
                            className: 'text-center'
                        },
                        {
                            data: 'tanggal_lhp',
                            name: 'tanggal_lhp',
                            className: 'text-center'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
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
                    $('#dataTable_info').appendTo('#tableInfo');
                    $('#dataTable_paginate').appendTo('#tablePagination');
                }

                dataTable.on('init.dt', moveDataTableFooter);
                dataTable.on('draw.dt', moveDataTableFooter);

                function openModal() {
                    reset();
                    $('#modalKasus')
                        .removeClass('pointer-events-none opacity-0');

                    $('#modalContent')
                        .removeClass('scale-95')
                        .addClass('scale-100');
                }

                function closeModal() {
                    $('#modalKasus')
                        .addClass('opacity-0 pointer-events-none');

                    $('#modalContent')
                        .removeClass('scale-100')
                        .addClass('scale-95');
                }

                function initSelect2() {
                    $('.opd').each(function() {
                        if ($(this).hasClass('select2-hidden-accessible')) {
                            return;
                        }

                        $(this).select2({
                            dropdownParent: $('#modalKasus'),
                            width: '100%',
                            placeholder: $(this).data('placeholder'),
                            allowClear: true
                        });
                    });
                }

                $("#openModalBtn").click(function() {
                    $('.modal-header').html('Form Tambah Kasus');
                    initSelect2();
                    openModal();
                });

                $("#closeModalBtn").click(function() {
                    reset();
                    closeModal();
                });

                $("#closeModalBtnTemuan").click(function() {
                    resetFormTemuan();
                    closeModalTemuan();
                });

                function cekNomorLhp() {

                    let kode_unor = $('#kode_unor').val();
                    let tahun = $('#tahun_pemeriksaan').val();
                    let nomor = $('#nomor_lhp').val();
                    let id = $('#id').val();

                    if (!kode_unor || !tahun || !nomor) return;

                    $.post('/cek-nomor-lhp', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        kode_unor: kode_unor,
                        tahun_pemeriksaan: tahun,
                        nomor_lhp: nomor,
                        id: id
                    }, function(res) {

                        if (res.exists) {
                            $('#nomor_lhp_error').html(
                                'Nomor LHP sudah digunakan pada OPD dan tahun tersebut.'
                            );
                            $('#btn-save').prop('disabled', true);
                        } else {
                            $('#nomor_lhp_error').html('');
                            $('#btn-save').prop('disabled', false);
                        }

                    });
                }

                $('#kode_unor,#tahun_pemeriksaan,#nomor_lhp').on('change blur', cekNomorLhp);

                $('#formKasus').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData($('#formKasus')[0]);
                    $.ajax({
                        type: 'POST',
                        url: URL.storeKasus,
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.err').html('');
                            let loading = `<svg aria-hidden="true" class="w-5 h-5 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Loading...</span>`
                            $('#btn-save').prop('disabled', true).addClass(
                                'disabled:bg-gray-400 disabled:cursor-not-allowed').html(
                                loading);
                            $('.cancel').prop('disabled', true).addClass(
                                'disabled:cursor-not-allowed');
                            $('#closeModalBtn').prop('disabled', true).addClass(
                                'disabled:cursor-not-allowed');
                        },

                        success: function(response) {
                            if (!response) {
                                Swal.fire({
                                    title: "Gagal",
                                    text: "Response server tidak valid",
                                    icon: "error"
                                });
                                return;
                            }
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                closeModal();
                                if ($.fn.DataTable.isDataTable('#dataTable')) {
                                    $('#dataTable').DataTable().ajax.reload(null,
                                        false);
                                }
                                Swal.fire({
                                    title: "Sukses",
                                    text: response.message,
                                    icon: "success"
                                });
                                reset();
                                $('.pick-kasus').addClass('hidden');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Terjadi kesalahan server",
                                icon: "error"
                            });
                        },
                        complete: function() {
                            $('#btn-save')
                                .prop('disabled', false).html('Simpan');
                            $('.cancel')
                                .prop('disabled', false);
                            $('#closeModalBtn')
                                .prop('disabled', false);
                        }
                    });
                });

                $(document).on('click', '.btn-deleteKasus', function() {
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#DC3545',
                        confirmButtonColor: '#28A745',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Yakin',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let id = $(this).data('id');
                            $.ajax({
                                type: "DELETE",
                                url: `${URL.storeKasus}/${id}`,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status) {
                                        $('#dataTable').DataTable().ajax.reload(function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: response.message,
                                                icon: "success"
                                            });
                                        }, false);
                                    }
                                },
                                error: function(xhr) {
                                    let message = "Terjadi kesalahan pada server.";
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        message = xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        title: "Gagal",
                                        text: message,
                                        icon: "error"
                                    });
                                }
                            });
                        }
                    })
                });

                $(document).on('click', '.btn-editKasus', function() {
                    let id = $(this).data('id');
                    $('.modal-header').html('Form Edit Kasus');
                    openModal()
                    $.ajax({
                        url: `${URL.storeKasus}/${id}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('#id').val(response.id);
                            $('#id_jenis_php').val(response.id_jenis_php);
                            $('#tahun_pemeriksaan').val(response.tahun_pemeriksaan).change();
                            $('#nomor_spt').val(response.nomor_spt);
                            $('#tanggal_spt').val(response.tanggal_spt);
                            $('#spt_mulai').val(response.spt_mulai);
                            $('#spt_selesai').val(response.spt_selesai);
                            $('#nomor_lhp').val(response.nomor_lhp);
                            $('#tanggal_lhp').val(response.tanggal_lhp);
                            initSelect2();
                            $('#kode_unor').val(response.kode_unor).trigger('change');
                            $('#nip_ketua').val(response.nip_ketua).trigger('change');
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                icon: "error"
                            });
                        }
                    });
                });

                // ── TAB TOGGLE (Kasus <-> Temuan) ───────────────────────────
                function showSection(id) {
                    $('#sectionKasus, #sectionTemuan').addClass('hidden');
                    $('#' + id).removeClass('hidden').css('opacity', 0).animate({
                        opacity: 1
                    }, 200);
                }

                let dtTemuanTable = null;

                $(document).on('click', '.btn-openTemuan', function() {
                    const idKasus = $(this).data('id');
                    $('#idKasus').val(idKasus);
                    showSection('sectionTemuan');

                    $('#tableLoadingTemuan').removeClass('hidden');
                    showInfoSkeleton();

                    loadDetailKasus(idKasus);

                    if ($.fn.DataTable.isDataTable('#dtTemuan')) {
                        $('#dtTemuan').DataTable().destroy();
                    }

                    $('#tableInfoTemuan').empty();
                    $('#tablePaginationTemuan').empty();

                    $('#dtTemuan').off('processing.dt').on('processing.dt', function(e, settings, processing) {
                        $('#tableLoadingTemuan').toggleClass('hidden', !processing);
                    });

                    dtTemuanTable = $('#dtTemuan').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        scrollX: true,
                        dom: 'rtip',
                        searching: true,
                        ordering: false,
                        lengthChange: false,
                        ajax: {
                            type: 'POST',
                            url: `{{ url('daftar-kasus') }}/${idKasus}/temuan/ajax`
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'total_rekomendasi',
                                name: 'total_rekomendasi',
                                className: 'text-left'
                            },
                            {
                                data: 'temuan',
                                name: 'temuan',
                                className: 'text-left'
                            },
                            {
                                data: 'penyebab',
                                name: 'penyebab',
                                className: 'text-left'
                            },
                            {
                                data: 'besaran_kerugian',
                                name: 'besaran_kerugian',
                                className: 'text-right'
                            },
                            {
                                data: 'besaran_kerugian2',
                                name: 'besaran_kerugian2',
                                className: 'text-right'
                            },
                            {
                                data: 'besaran_kerugian3',
                                name: 'besaran_kerugian3',
                                className: 'text-right'
                            },
                            {
                                data: 'besaran_kerugian4',
                                name: 'besaran_kerugian4',
                                className: 'text-right'
                            },
                            {
                                data: 'log',
                                name: 'log',
                                className: 'text-left'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            }
                        ],
                        language: {
                            processing: "",
                            zeroRecords: "Data tidak ditemukan",
                            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                            paginate: {
                                previous: "←",
                                next: "→"
                            }
                        },
                        initComplete: function() {
                            $('#dtTemuan_info').appendTo('#tableInfoTemuan');
                            $('#dtTemuan_paginate').appendTo('#tablePaginationTemuan');
                        }
                    });

                    $('#customSearchTemuan').off('input').on('input', function() {
                        dtTemuanTable.search(this.value).draw();
                    });

                    $('#pageLengthTemuan').off('change').on('change', function() {
                        dtTemuanTable.page.len(this.value).draw();
                    });
                });

                $('#btn-backToKasus').click(function() {
                    showSection('sectionKasus');
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().ajax.reload(null, false);
                    }
                });

                function showInfoSkeleton() {
                    const skeleton =
                        '<span class="inline-block h-4 w-32 animate-pulse rounded bg-gray-200 dark:bg-gray-700"></span>';
                    $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik').html(skeleton);
                }

                function loadDetailKasus(idKasus) {
                    $.ajax({
                        url: `{{ url('daftar-kasus') }}/${idKasus}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('.info-tanggal-lhp').html(response.tanggal_lhp ?? '-');
                            $('.info-nomor-lhp').html(response.nomor_lhp ?? '-');
                            $('.info-nama-obrik').html(response.kode_unor ?? '-');
                        },
                        error: function() {
                            $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik').html(
                                '<span class="text-red-500">Gagal memuat</span>');
                        }
                    });
                }

                // ── MODAL TEMUAN ─────────────────────────────────────────────
                function openModalTemuan() {
                    $('#modalTemuan').removeClass('pointer-events-none opacity-0');
                    $('#modalTemuanContent').removeClass('scale-95').addClass('scale-100');
                }

                function closeModalTemuan() {
                    $('#modalTemuan').addClass('opacity-0 pointer-events-none');
                    $('#modalTemuanContent').removeClass('scale-100').addClass('scale-95');
                }

                function resetFormTemuan() {
                    $('#temuan_id').val('');
                    $('#formTemuan')[0].reset();
                    $('#formTemuan .err').empty();
                    toggleBesaranKerugian();
                    toggleBesaranKerugian(2);
                    toggleBesaranKerugian(3);
                    toggleBesaranKerugian(4);
                }

                $('#btn-add-temuan').click(function() {
                    resetFormTemuan();
                    openModalTemuan();
                });

                $('#btn-cancel-temuan').click(function() {
                    resetFormTemuan();
                    closeModalTemuan();
                });

                function toggleBesaranKerugian(index = '') {
                    const suffix = index === 1 ? '' : index;
                    const nilai = $('#id_nilai_kerugian' + suffix).val();
                    if (nilai == '0') {
                        $('#col_besaran_kerugian' + suffix).addClass('hidden');
                        $('#col_id_nilai_kerugian' + suffix)
                            .removeClass('w-1/2')
                            .addClass('w-full');
                        $('#besaran_kerugian' + suffix).val('');
                        $('#besaran_kerugian_error' + suffix).text('');
                    } else {
                        $('#col_besaran_kerugian' + suffix).removeClass('hidden');
                        $('#col_id_nilai_kerugian' + suffix)
                            .removeClass('w-full')
                            .addClass('w-1/2');
                    }
                }

                $(function() {
                    [1, 2, 3, 4].forEach(function(i) {
                        toggleBesaranKerugian(i);
                        $('#id_nilai_kerugian' + (i == 1 ? '' : i))
                            .on('change', function() {
                                toggleBesaranKerugian(i);
                            });
                    });
                });

                $('#formTemuan').submit(function(e) {
                    e.preventDefault();
                    const idKasus = $('#idKasus').val();
                    const formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: `{{ url('daftar-kasus') }}/${idKasus}/temuan`,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.err').empty();
                            $('#btn-save-temuan').prop('disabled', true).text('Menyimpan...');
                        },
                        success: function(response) {
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                $('#dtTemuan').DataTable().ajax.reload(null, false);
                                closeModalTemuan();
                                resetFormTemuan();
                                Swal.fire({
                                    title: 'Sukses',
                                    text: response.message,
                                    icon: 'success'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi kesalahan server',
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('#btn-save-temuan').prop('disabled', false).text('Simpan');
                        }
                    });
                });

                $(document).on('click', '.btn-editTemuan', function() {
                    const id = $(this).data('id');
                    resetFormTemuan();
                    openModalTemuan();

                    $.ajax({
                        url: `{{ url('temuan') }}/${id}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('#temuan_id').val(response.id);
                            $('#temuan').val(response.temuan);
                            $('#penyebab').val(response.penyebab);
                            for (let i = 1; i <= 4; i++) {
                                const suffix = i === 1 ? '' : i;

                                $('#id_nilai_kerugian' + suffix).val(response['id_nilai_kerugian' +
                                    suffix]);
                                $('#besaran_kerugian' + suffix).val(response['besaran_kerugian' +
                                    suffix]);

                                toggleBesaranKerugian(i);
                            }
                        }
                    });
                });

                $(document).on('click', '.btn-deleteTemuan', function() {
                    const id = $(this).data('id');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Yakin',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url('temuan') }}/${id}`,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status) {
                                        $('#dtTemuan').DataTable().ajax.reload(function() {
                                            Swal.fire({
                                                title: "Sukses",
                                                text: response.message,
                                                icon: "success"
                                            });
                                        }, false);
                                    }
                                },
                                error: function(xhr) {
                                    let message = "Terjadi kesalahan pada server.";
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        message = xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        title: "Gagal",
                                        text: message,
                                        icon: "error"
                                    });
                                }
                            });
                        }
                    });
                });

                $('.cancel').click(function(e) {
                    e.preventDefault();
                    reset();
                    closeModal();
                });

                function reset() {
                    $('#id').val('');
                    $('#formKasus')[0].reset();
                    $('.err').empty();
                    $('#kode_unor, #nip_ketua').each(function() {
                        if ($(this).hasClass('select2-hidden-accessible')) {
                            $(this).val(null).trigger('change');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
