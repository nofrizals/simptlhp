@extends('layouts.app')

@section('title', 'Manajemen Tim Obrik | SIMPTLHP')
@section('page-data', "'obrik-ditangani'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Manajemen Tim Obrik
                        </h3>
                        <p class="text-sm text-gray-500">
                            Kelola seluruh obrik ditangani
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
                        <input id="customSearch" type="text" placeholder="Cari obrik..."
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
                    <table id="dataTable" class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama Obrik
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Tim Yang
                                    Menangani</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">Aksi</th>
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
    <div id="modalObrikDitangani"
        class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
        <div id="modalContent"
            class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 
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
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="modal-header text-base font-medium text-gray-800 dark:text-white/90"></h3>
                </div>
                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <form id="formObrikTim">
                        <div class="-mx-2.5 flex flex-wrap gap-y-5">
                            <input type="hidden"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                id="id" name="id">
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Obrik
                                </label>
                                <textarea name="nama_instansi" id="nama_instansi" placeholder="Enter a description..." type="text" rows="2"
                                    disabled
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                                <p class="err text-theme-xs text-error-500" id="nama_instansi_error"></p>
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                    Tim Yang Menangani</label>
                                <select name="id_tim" id="id_tim"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" disabled selected
                                        class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih Tim</option>
                                    @foreach ($tims as $tim)
                                        <option value="{{ $tim->id }}">
                                            {{ $tim->name }} - {{ $tim->nip_ketua }}</option>
                                    @endforeach
                                </select>
                                <p class="err text-theme-xs text-error-500" id="id_tim_error"></p>
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
    @push('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // ─── URL ───────────────────────────────────────────────
                const URL = {
                    ajaxObrikTim: "{{ url('ajax-obrik-tim') }}",
                    storeObrikTim: "{{ url('obrik-tim') }}",
                };

                // ─── Spinner HTML ────────────────────────────────────────────────
                const SPINNER_HTML = `
                        <svg aria-hidden="true" class="w-5 h-5 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>`;

                // LOADING
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
                        url: URL.ajaxObrikTim
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama_instansi',
                            name: 'nama_instansi',
                            className: 'text-left'
                        },
                        {
                            data: 'id_tim',
                            name: 'id_tim',
                            className: 'text-left'
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
                    $('#dataTable_info').appendTo('#tableInfo');
                    $('#dataTable_paginate').appendTo('#tablePagination');
                }

                dataTable.on('init.dt', moveDataTableFooter);
                dataTable.on('draw.dt', moveDataTableFooter);

                function openModal() {
                    $('#modalObrikDitangani')
                        .removeClass('pointer-events-none opacity-0');

                    $('#modalContent')
                        .removeClass('scale-95')
                        .addClass('scale-100');
                }

                function closeModal() {
                    $('#modalObrikDitangani')
                        .addClass('opacity-0 pointer-events-none');

                    $('#modalContent')
                        .removeClass('scale-100')
                        .addClass('scale-95');
                }

                $("#closeModalBtn").click(function() {
                    reset();
                    closeModal();
                });

                $('#formObrikTim').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData($('#formObrikTim')[0]);
                    $.ajax({
                        type: 'POST',
                        url: URL.storeObrikTim,
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
                                $('.pick-tim').addClass('hidden');
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
                                .prop('disabled', false)
                                .html('Simpan');
                        }
                    });
                });

                $(document).on('click', '.btn-deleteObrikTim', function() {
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
                                type: "delete",
                                url: `${URL.storeTim}/${id}`,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status) {
                                        $('#dataTable').DataTable().ajax.reload(
                                            function() {
                                                Swal.fire({
                                                    title: "Sukses",
                                                    text: response.message,
                                                    icon: "success"
                                                });
                                            }, false);
                                    } else {
                                        Swal.fire({
                                            title: "Gagal",
                                            text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                            icon: "error"
                                        });
                                    }
                                }
                            });
                        }
                    })
                });

                $(document).on('click', '.btn-editObrikTim', function() {
                    let data = $(this).data();
                    openModal();
                    $('.modal-header').html(
                        'Form Edit Obrik Yang Ditangani');
                    $('#id').val(data.id);
                    $('#nama_instansi').val(data.instansi);
                    $('#id_tim').val(data.tim);
                });

                $('.cancel').click(function(e) {
                    e.preventDefault();
                    reset();
                    closeModal();
                });

                function reset() {
                    $('#id').val('');
                    $('#formObrikTim')[0].reset();
                    $('.err').empty();
                }
            });
        </script>
    @endpush
@endsection
