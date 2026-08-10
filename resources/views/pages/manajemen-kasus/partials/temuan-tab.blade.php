<div id="sectionTemuan" class="hidden">
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            <a href="javascript:void(0)" id="btn-backToKasus"
                                class="inline-flex items-center gap-2 hover:text-brand-500">
                                &larr; Daftar Temuan
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">Kelola temuan untuk kasus terpilih</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="btn-add-temuan"
                            class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                            + Tambah Temuan
                        </button>
                        <!-- Reload -->
                        <button type="button" id="btnReloadTemuan"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                            title="Reload Data">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v6h6M20 20v-6h-6M20 9A8 8 0 006.34 5.34L4 10M4 15a8 8 0 0013.66 3.66L20 14" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- INFO KASUS --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" id="idKasus" value="">
                    <table class="text-sm text-gray-500">
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Tanggal LHP</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-tanggal-lhp"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Nomor LHP</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-nomor-lhp"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Nama Obrik</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-nama-obrik"></span>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- TOOLBAR --}}
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Tampilkan</span>
                        <select id="pageLengthTemuan"
                            class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input id="customSearchTemuan" type="text" placeholder="Cari temuan..."
                            class="h-10 w-72 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                {{-- Loading --}}
                <div id="tableLoadingTemuan"
                    class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Loading...</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="dtTemuan" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Rekomendasi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Temuan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Penyebab
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kerugian
                                    Pajak
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kerugian
                                    Daerah
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kerugian
                                    Desa
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kerugian
                                    BLUD
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Log</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 align-top"></tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div
                    class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div id="tableInfoTemuan" class="text-sm text-gray-500"></div>
                    <div id="tablePaginationTemuan"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Temuan --}}
<div id="modalTemuan"
    class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
    <div id="modalTemuanContent"
        class="relative w-full max-w-[800px] rounded-3xl bg-white p-6 
            transform scale-95 transition-transform duration-300
            dark:bg-gray-900 lg:p-10">
        <button id="closeModalBtnTemuan"
            class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                    fill="" />
            </svg>
        </button>
        <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 pb-3 pt-3">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Form Temuan</h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <form id="formTemuan">
                    <div class="-mx-2.5 flex flex-wrap gap-y-5">
                        <input type="hidden" id="temuan_id" name="id">
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div class="w-1/2">
                                    <label for="temuan"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Temuan
                                        <span class="text-red-400">*</span></label>
                                    <textarea
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        name="temuan" id="temuan" rows="6"></textarea>
                                    <p class="err text-theme-xs text-error-500" id="temuan_error"></p>
                                </div>
                                <div class="w-1/2">
                                    <label for="penyebab"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Penyebab
                                        <span class="text-red-400">*</span></label>
                                    <textarea
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        name="penyebab" id="penyebab" rows="6"></textarea>
                                    <p class="err text-theme-xs text-error-500" id="penyebab_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div id="col_id_nilai_kerugian" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kerugian Pajak <span class="text-red-400">*</span>
                                    </label>
                                    <select name="id_nilai_kerugian" id="id_nilai_kerugian"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="1" selected
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            PPN/PPH
                                        </option>
                                        <option value="0"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Tidak Ada
                                        </option>
                                    </select>
                                    <p class="err text-theme-xs text-error-500" id="id_nilai_kerugian_error"></p>
                                </div>
                                <div id="col_besaran_kerugian" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Besaran Kerugian Pajak <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" name="besaran_kerugian" id="besaran_kerugian"
                                        placeholder="Besaran Kerugian"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <p class="err text-theme-xs text-error-500" id="besaran_kerugian_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div id="col_id_nilai_kerugian2" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kerugian Daerah <span class="text-red-400">*</span>
                                    </label>
                                    <select name="id_nilai_kerugian2" id="id_nilai_kerugian2"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="1" selected
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Daerah (Restoran)
                                        </option>
                                        <option value="0"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Tidak Ada
                                        </option>
                                    </select>
                                    <p class="err text-theme-xs text-error-500" id="id_nilai_kerugian2_error"></p>
                                </div>
                                <div id="col_besaran_kerugian2" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Besaran Kerugian Daerah <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" name="besaran_kerugian2" id="besaran_kerugian2"
                                        placeholder="Besaran Kerugian"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <p class="err text-theme-xs text-error-500" id="besaran_kerugian2_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div id="col_id_nilai_kerugian3" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kerugian Desa <span class="text-red-400">*</span>
                                    </label>
                                    <select name="id_nilai_kerugian3" id="id_nilai_kerugian3"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="1" selected
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Kampung / Desa
                                        </option>
                                        <option value="0"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Tidak Ada
                                        </option>
                                    </select>
                                    <p class="err text-theme-xs text-error-500" id="id_nilai_kerugian3_error"></p>
                                </div>
                                <div id="col_besaran_kerugian3" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Besaran Kerugian Desa <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" name="besaran_kerugian3" id="besaran_kerugian3"
                                        placeholder="Besaran Kerugian"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <p class="err text-theme-xs text-error-500" id="besaran_kerugian3_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div id="col_id_nilai_kerugian4" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kerugian BLUD <span class="text-red-400">*</span>
                                    </label>
                                    <select name="id_nilai_kerugian4" id="id_nilai_kerugian4"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="1" selected
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            BLUD
                                        </option>
                                        <option value="0"
                                            class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Tidak Ada
                                        </option>
                                    </select>
                                    <p class="err text-theme-xs text-error-500" id="id_nilai_kerugian4_error"></p>
                                </div>
                                <div id="col_besaran_kerugian4" class="w-1/2">
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Besaran Kerugian BLUD <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" name="besaran_kerugian4" id="besaran_kerugian4"
                                        placeholder="Besaran Kerugian"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <p class="err text-theme-xs text-error-500" id="besaran_kerugian4_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5">
                            <div class="mt-1 flex items-center gap-3">
                                <button type="submit" id="btn-save-temuan"
                                    class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                                    Simpan
                                </button>
                                <button type="button" id="btn-cancel-temuan"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('pages.manajemen-kasus.partials.rekomendasi-tab')
@push('scripts')
    <script>
        $(document).ready(function() {
            function showSection(id) {
                $('#sectionTemuan, #sectionRekomendasi').addClass('hidden');
                $('#' + id).removeClass('hidden').css('opacity', 0).animate({
                    opacity: 1
                }, 200);
            }

            let dtRekomendasiTable = null;

            $(document).on('click', '.btn-openRekomendasi', function() {
                const idTemuan = $(this).data('id');
                $('#idTemuan').val(idTemuan);
                showSection('sectionRekomendasi');

                $('#tableLoadingRekomendasi').removeClass('hidden');
                showInfoSkeleton();

                loadDetailTemuan(idTemuan);

                if ($.fn.DataTable.isDataTable('#dtRekomendasi')) {
                    $('#dtRekomendasi').DataTable().destroy();
                }

                $('#tableInfoRekomendasi').empty();
                $('#tablePaginationRekomendasi').empty();

                $('#dtRekomendasi').off('processing.dt').on('processing.dt', function(e, settings,
                    processing) {
                    $('#tableLoadingRekomendasi').toggleClass('hidden', !processing);
                });

                dtRekomendasiTable = $('#dtRekomendasi').DataTable({
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
                        url: `{{ url('daftar-kasus') }}/${idTemuan}/rekomendasi/ajax`
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'tindak_lanjut',
                            name: 'tindak_lanjut',
                            className: 'text-left'
                        },
                        {
                            data: 'rekomendasi',
                            name: 'rekomendasi',
                            className: 'text-left'
                        },
                        {
                            data: 'tgl_input',
                            name: 'tgl_input',
                            className: 'text-left'
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
                        $('#dtRekomendasi_info').appendTo('#tableInfoRekomendasi');
                        $('#dtRekomendasi_paginate').appendTo('#tablePaginationRekomendasi');
                    }
                });

                $('#customSearchRekomendasi').off('input').on('input', function() {
                    dtRekomendasiTable.search(this.value).draw();
                });

                $('#pageLengthRekomendasi').off('change').on('change', function() {
                    dtRekomendasiTable.page.len(this.value).draw();
                });

                $('#btn-backToTemuan').click(function() {
                    showSection('sectionTemuan');
                    const idTemuan = $('#idTemuan').val();
                    if (idTemuan) {
                        showInfoSkeleton()
                        loadDetailTemuan(idTemuan);
                    }
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().ajax.reload(null, false);
                    }
                });

                function showInfoSkeleton() {
                    const skeleton =
                        '<span class="inline-block h-4 w-32 animate-pulse rounded bg-gray-200 dark:bg-gray-700"></span>';
                    $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik, .info-jenis-php, .info-temuan, .info-penyebab')
                        .html(skeleton);
                }

                function loadDetailTemuan(idTemuan) {
                    $.ajax({
                        url: `{{ url('temuan') }}/${idTemuan}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('.info-tanggal-lhp').html(response.tanggal_lhp ?? '-');
                            $('.info-nomor-lhp').html(response.nomor_lhp ?? '-');
                            $('.info-nama-obrik').html(response.kode_unor ?? '-');
                            $('.info-jenis-php').html(response.id_jenis_php ?? '-');
                            $('.info-temuan').html(response.temuan ?? '-');
                            $('.info-penyebab').html(response.penyebab ?? '-');
                        },
                        error: function() {
                            $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik, .info-jenis-php, .info-temuan, .info-penyebab')
                                .html(
                                    '<span class="text-red-500">Gagal memuat</span>');
                        }
                    });
                }

                function openModalRekomendasi() {
                    $('#modalRekomendasi').removeClass('pointer-events-none opacity-0');
                    $('#modalRekomendasiContent').removeClass('scale-95').addClass('scale-100');
                }

                function closeModalRekomendasi() {
                    $('#modalRekomendasi').addClass('opacity-0 pointer-events-none');
                    $('#modalRekomendasiContent').removeClass('scale-100').addClass('scale-95');
                }

                function resetFormRekomendasi() {
                    $('#rekomendasi_id').val('');
                    $('#formRekomendasi')[0].reset();
                    $('#formRekomendasi .err').empty();
                }

                $('#btn-add-rekomendasi').click(function() {
                    resetFormRekomendasi();
                    openModalRekomendasi();
                });

                $('#btn-cancel-rekomendasi, #closeModalBtnRekomendasi').click(function() {
                    resetFormRekomendasi();
                    closeModalRekomendasi();
                });

                $('#formRekomendasi').submit(function(e) {
                    e.preventDefault();
                    const idTemuan = $('#idTemuan').val();
                    const formData = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: `{{ url('daftar-kasus') }}/${idTemuan}/rekomendasi`,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btn-save-rekomendasi').prop('disabled', true).text(
                                'Menyimpan...');
                        },
                        success: function(response) {
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                $('#dtRekomendasi').DataTable().ajax.reload(null,
                                    false);
                                closeModalRekomendasi();
                                resetFormRekomendasi();
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
                            $('#btn-save-rekomendasi').prop('disabled', false).text(
                                'Simpan');
                        }
                    });
                });

                $(document).on('click', '.btn-editRekomendasi', function() {
                    const id = $(this).data('id');
                    resetFormRekomendasi();
                    openModalRekomendasi();

                    $.ajax({
                        url: `{{ url('rekomendasi') }}/${id}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('#rekomendasi_id').val(response.id);
                            $('#rekomendasi').val(response.rekomendasi);
                        }
                    });
                });

                $(document).on('click', '.btn-deleteRekomendasi', function() {
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
                                url: `{{ url('rekomendasi') }}/${id}`,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status) {
                                        $('#dtRekomendasi').DataTable().ajax
                                            .reload(
                                                function() {
                                                    Swal.fire({
                                                        title: "Sukses",
                                                        text: response
                                                            .message,
                                                        icon: "success"
                                                    });
                                                }, false);
                                    }
                                },
                                error: function(xhr) {
                                    let message =
                                        "Terjadi kesalahan pada server.";
                                    if (xhr.responseJSON && xhr.responseJSON
                                        .message) {
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
            });
        });
    </script>
@endpush
