<div id="sectionRekomendasi" class="hidden">
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            <a href="javascript:void(0)" id="btn-backToTemuan"
                                class="inline-flex items-center gap-2 hover:text-brand-500">
                                &larr; Daftar Rekomendasi
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">Kelola rekomendasi untuk temuan terpilih</p>
                    </div>
                    <button type="button" id="btn-add-rekomendasi"
                        class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        + Tambah Rekomendasi
                    </button>
                </div>

                {{-- INFO KASUS --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" id="idTemuan" value="">
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
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Jenis PHP</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-jenis-php"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5 align-top">Temuan</td>
                            <td class="pr-2 align-top">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-temuan"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5 align-top">Penyebab</td>
                            <td class="pr-2 align-top">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-penyebab"></span>
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- TOOLBAR --}}
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Tampilkan</span>
                        <select id="pageLengthRekomendasi"
                            class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input id="customSearchRekomendasi" type="text" placeholder="Cari rekomendasi..."
                            class="h-10 w-72 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                {{-- Loading --}}
                <div id="tableLoadingRekomendasi"
                    class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Loading...</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="dtRekomendasi" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Tindak Lanjut
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Rekomendasi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                    Tanggal Input Rekomendasi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Log
                                </th>
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
                    <div id="tableInfoRekomendasi" class="text-sm text-gray-500"></div>
                    <div id="tablePaginationRekomendasi"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Rekomendasi --}}
{{-- <div id="modalRekomendasi"
    class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto p-5 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
    <div id="modalRekomendasiContent"
        class="relative w-full max-w-[800px] scale-95 transform rounded-3xl bg-white p-6 transition-transform duration-300 dark:bg-gray-900 lg:p-10">
        <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 pb-3 pt-3">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Form Rekomendasi</h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <form id="formRekomendasi">
                    <input type="hidden" id="rekomendasi_id" name="id">

                    <div class="mb-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Temuan
                            <span class="text-red-400">*</span></label>
                        <textarea name="temuan" id="temuan" rows="4"
                            class="h-auto w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                        <p class="err text-theme-xs text-error-500" id="temuan_error"></p>
                    </div>

                    <div class="mb-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Penyebab
                            <span class="text-red-400">*</span></label>
                        <textarea name="penyebab" id="penyebab" rows="4"
                            class="h-auto w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"></textarea>
                        <p class="err text-theme-xs text-error-500" id="penyebab_error"></p>
                    </div>

                    <h5 class="mb-3 font-semibold">Kolom Kerugian</h5>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kerugian
                                Pajak</label>
                            <input type="number" step="0.01" name="besaran_kerugian" id="besaran_kerugian"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <p class="err text-theme-xs text-error-500" id="besaran_kerugian_error"></p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kerugian
                                Daerah</label>
                            <input type="number" step="0.01" name="besaran_kerugian2" id="besaran_kerugian2"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <p class="err text-theme-xs text-error-500" id="besaran_kerugian2_error"></p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kerugian
                                Desa</label>
                            <input type="number" step="0.01" name="besaran_kerugian3" id="besaran_kerugian3"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <p class="err text-theme-xs text-error-500" id="besaran_kerugian3_error"></p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kerugian
                                BLUD</label>
                            <input type="number" step="0.01" name="besaran_kerugian4" id="besaran_kerugian4"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <p class="err text-theme-xs text-error-500" id="besaran_kerugian4_error"></p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit" id="btn-save-temuan"
                            class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                            Simpan
                        </button>
                        <button type="button" id="btn-cancel-temuan"
                            class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}







@include('pages.manajemen-kasus.partials.tindaklanjut-tab')
@push('scripts')
    <script>
        $(document).ready(function() {
            function showSection(id) {
                $('#sectionRekomendasi, #sectionTindakLanjut').addClass('hidden');
                $('#' + id).removeClass('hidden').css('opacity', 0).animate({
                    opacity: 1
                }, 200);
            }

            let dtTindakLanjutTable = null;
            $(document).on('click', '.btn-openTindakLanjut', function() {
                const idRekomendasi = $(this).data('id');
                $('#idRekomendasi').val(idRekomendasi);
                showSection('sectionTindakLanjut');
                $('#tableLoadingTindakLanjut').removeClass('hidden');
                showInfoSkeleton();

                loadDetailRekomendasi(idRekomendasi);

                if ($.fn.DataTable.isDataTable('#dtTindakLanjut')) {
                    $('#dtTindakLanjut').DataTable().destroy();
                }

                $('#tableInfoTindakLanjut').empty();
                $('#tablePaginationTindakLanjut').empty();

                $('#dtTindakLanjut').off('processing.dt').on('processing.dt', function(e, settings,
                    processing) {
                    $('#tableLoadingTindakLanjut').toggleClass('hidden', !processing);
                });
                dtTindakLanjutTable = $('#dtTindakLanjut').DataTable({
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
                        url: `{{ url('daftar-kasus') }}/${idRekomendasi}/tindak_lanjut/ajax`
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
                            className: 'text-left'
                        },
                        {
                            data: 'tindak_lanjut',
                            name: 'tindak_lanjut',
                            className: 'text-left'
                        },
                        {
                            data: 'rincian_temuan_keuangan_pajak',
                            name: 'rincian_temuan_keuangan_pajak',
                            className: 'text-left'
                        },
                        {
                            data: 'rincian_temuan_keuangan_daerah',
                            name: 'rincian_temuan_keuangan_daerah',
                            className: 'text-left'
                        },
                        {
                            data: 'rincian_temuan_keuangan_desa',
                            name: 'rincian_temuan_keuangan_desa',
                            className: 'text-left'
                        },
                        {
                            data: 'rincian_temuan_keuangan_blud',
                            name: 'rincian_temuan_keuangan_blud',
                            className: 'text-left'
                        },
                        {
                            data: 'status_tindak_lanjut',
                            name: 'status_tindak_lanjut',
                            className: 'text-left'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
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
                        $('#dtTindakLanjut_info').appendTo('#tableInfoTindakLanjut');
                        $('#dtTindakLanjut_paginate').appendTo('#tablePaginationTindakLanjut');
                    }
                });

                $('#customSearchTindakLanjut').off('input').on('input', function() {
                    dtTindakLanjutTable.search(this.value).draw();
                });

                $('#pageLengthTindakLanjut').off('change').on('change', function() {
                    dtTindakLanjutTable.page.len(this.value).draw();
                });

                $('#btn-backToRekomendasi').click(function() {
                    showSection('sectionRekomendasi');
                    const idRekomendasi = $('#idRekomendasi').val();
                    if (idRekomendasi) {
                        showInfoSkeleton()
                        loadDetailRekomendasi(idRekomendasi);
                    }
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().ajax.reload(null, false);
                    }
                });

                function showInfoSkeleton() {
                    const skeleton =
                        '<span class="inline-block h-4 w-32 animate-pulse rounded bg-gray-200 dark:bg-gray-700"></span>';
                    $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik, .info-jenis-php, .info-temuan, .info-penyebab, .info-rekomendasi')
                        .html(skeleton);
                }

                function loadDetailRekomendasi(idRekomendasi) {
                    $.ajax({
                        url: `{{ url('rekomendasi') }}/${idRekomendasi}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('.info-tanggal-lhp').html(response.tanggal_lhp ?? '-');
                            $('.info-nomor-lhp').html(response.nomor_lhp ?? '-');
                            $('.info-nama-obrik').html(response.kode_unor ?? '-');
                            $('.info-jenis-php').html(response.id_jenis_php ?? '-');
                            $('.info-temuan').html(response.temuan ?? '-');
                            $('.info-penyebab').html(response.penyebab ?? '-');
                            $('.info-rekomendasi').html(response.rekomendasi ?? '-');
                        },
                        error: function() {
                            $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik, .info-jenis-php, .info-temuan, .info-penyebab, .info-rekomendasi')
                                .html(
                                    '<span class="text-red-500">Gagal memuat</span>');
                        }
                    });
                }

                function openModalTindakLanjut() {
                    $('#modalTindakLanjut').removeClass('pointer-events-none opacity-0');
                    $('#modalTindakLanjutContent').removeClass('scale-95').addClass('scale-100');
                }

                function closeModalTindakLanjut() {
                    $('#modalTindakLanjut').addClass('opacity-0 pointer-events-none');
                    $('#modalTindakLanjutContent').removeClass('scale-100').addClass('scale-95');
                }

                function resetFormTindakLanjut() {
                    $('#tindak_lanjut_id').val('');
                    $('#formTindakLanjut')[0].reset();
                    $('#formTindakLanjut .err').empty();
                }

                $('#btn-add-tindak-lanjut').click(function() {
                    resetFormTindakLanjut();
                    openModalTindakLanjut();
                });

                $('#btn-cancel-tindak-lanjut').click(function() {
                    resetFormTindakLanjut();
                    closeModalTindakLanjut();
                });

                $('#formTindakLanjut').submit(function(e) {
                    e.preventDefault();
                    const idRekomendasi = $('#idRekomendasi').val();
                    const formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: `{{ url('daftar-kasus') }}/${idRekomendasi}/tindak_lanjut`,
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btn-save-tindak-lanjut').prop('disabled', true).text(
                                'Menyimpan...');
                        },
                        success: function(response) {
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                $('#dtTindakLanjut').DataTable().ajax.reload(null,
                                    false);
                                closeModalTindakLanjut();
                                resetFormTindakLanjut();
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
                            $('#btn-save-tindak-lanjut').prop('disabled', false).text(
                                'Simpan');
                        }
                    });
                });

                $(document).on('click', '.btn-editTindakLanjut', function() {
                    const id = $(this).data('id');
                    resetFormTindakLanjut();
                    openModalTindakLanjut();

                    $.ajax({
                        url: `{{ url('tindak_lanjut') }}/${id}/edit`,
                        type: 'GET',
                        success: function(response) {
                            $('#tindak_lanjut_id').val(response.id);
                            $('#tindak_lanjut').val(response.tindak_lanjut);
                        }
                    });
                });

                $(document).on('click', '.btn-deleteTindakLanjut', function() {
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
                                type: 'DELETE',
                                url: `{{ url('tindak_lanjut') }}/${id}`,
                                dataType: 'json',
                                success: function(response) {
                                    $('#dtTindakLanjut').DataTable().ajax
                                        .reload(
                                            null,
                                            false);
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: response.message,
                                        icon: 'success'
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
