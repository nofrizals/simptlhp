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
<div id="modalRekomendasi"
    class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
    <div id="modalRekomendasiContent"
        class="relative w-full max-w-[800px] rounded-3xl bg-white p-6 
            transform scale-95 transition-transform duration-300
            dark:bg-gray-900 lg:p-10">
        <button id="closeModalBtnRekomendasi"
            class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                    fill="" />
            </svg>
        </button>
        <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 pb-3 pt-3">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Form Rekomendasi</h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <form id="formRekomendasi">
                    <div class="-mx-2.5 flex flex-wrap gap-y-5">
                        <input type="hidden" id="rekomendasi_id" name="id">
                        <div class="w-full px-2.5 xl:w-1/2">
                            <div class="flex gap-3">
                                <div class="w-full">
                                    <label for="rekomendasi"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Rekomendasi</label>
                                    <textarea
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        name="rekomendasi" id="rekomendasi" rows="6"></textarea>
                                    <p class="err text-theme-xs text-error-500" id="rekomendasi_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2.5">
                            <div class="mt-1 flex items-center gap-3">
                                <button type="submit" id="btn-save-rekomendasi"
                                    class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                                    Simpan
                                </button>
                                <button type="button" id="btn-cancel-rekomendasi"
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

@include('pages.manajemen-kasus.partials.tindaklanjut-tab')
@push('scripts')
    <script>
        $(document).ready(function() {
            function showSection(id) {
                $('#sectionRekomendasi, #sectionTindakLanjut').addClass('hidden');
                $('#' + id).removeClass('hidden').css('opacity', 0).animate({
                    opacity: 1
                }, 200);
                isTindakLanjutAvailable();
            }

            function isTindakLanjutAvailable() {
                let idRekomendasi = $('#idRekomendasi').val();
                $.ajax({
                    url: "{{ url('tindak_lanjut/cek') }}",
                    type: "POST",
                    data: {
                        id_rekomendasi: idRekomendasi,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#btn-add-tindak-lanjut').prop('disabled', response.exists);

                        if (response.exists) {
                            $('#btn-add-tindak-lanjut')
                                .addClass('opacity-50 cursor-not-allowed');
                        } else {
                            $('#btn-add-tindak-lanjut')
                                .prop('disabled', false)
                                .removeClass('opacity-50 cursor-not-allowed');
                        }
                    }
                });
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
            });

            $('#btn-backToRekomendasi').click(function() {
                const containerHidden = $('#containerTable').hasClass('hidden');
                const pembayaranHidden = $('#pembayaranTable').hasClass('hidden');
                if (containerHidden && !pembayaranHidden) {
                    $('#containerTable').removeClass('hidden');
                    $('#pembayaranTable').addClass('hidden');
                } else {
                    showSection('sectionRekomendasi');
                    const idRekomendasi = $('#idRekomendasi').val();
                    if (idRekomendasi) {
                        showInfoSkeleton();
                        loadDetailRekomendasi(idRekomendasi);
                    }
                    if ($.fn.DataTable.isDataTable('#dtRekomendasi')) {
                        $('#dtRekomendasi').DataTable().ajax.reload(null, true);
                    }

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
                let idTemuan = $('#idTemuan').val();
                loadKerugian(idTemuan);
            }

            function closeModalTindakLanjut() {
                $('#modalTindakLanjut').addClass('opacity-0 pointer-events-none');
                $('#modalTindakLanjutContent').removeClass('scale-100').addClass('scale-95');
            }

            function resetFormTindakLanjut() {
                $('#tindak_lanjut_id').val('');
                $('#formTindakLanjut')[0].reset();
                $('#formTindakLanjut .err').empty();
                $('#besaran_kerugian').val(0);
                $('#besaran_kerugian2').val(0);
                $('#besaran_kerugian3').val(0);
                $('#besaran_kerugian4').val(0);
            }

            $('#btn-add-tindak-lanjut').click(function() {
                resetFormTindakLanjut();
                openModalTindakLanjut();
            });

            $('#btn-cancel-tindak-lanjut, #closeModalBtnTindakLanjut').click(function() {
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
                            isTindakLanjutAvailable();
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
                                $('#btn-add-tindak-lanjut')
                                    .prop('disabled', false)
                                    .removeClass(
                                        'opacity-50 cursor-not-allowed');
                            }
                        });
                    }
                });
            });

            let tindak_lanjut = '';

            $(document).on('click', '.pembayaran', function() {
                $('#containerTable').addClass('hidden');
                $('#pembayaranTable').removeClass('hidden');
                let id_tindak_lanjut = $('#idRekomendasi').val();
                loadTemuan(id_tindak_lanjut);
                id_tindak_lanjut = $(this).data('id');
                $('#id_tindak_lanjut').val(id_tindak_lanjut);

                if ($.fn.DataTable.isDataTable('#dtBuktiPembayaran')) {
                    dtBuktiPembayaranTable.ajax.url(
                        `{{ url('daftar-kasus') }}/${id_tindak_lanjut}/tindak_lanjut/ajaxPembayaran`
                    ).load();
                } else {
                    dtBuktiPembayaranTable = $('#dtBuktiPembayaran')
                        .DataTable({
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
                                url: `{{ url('daftar-kasus') }}/${id_tindak_lanjut}/tindak_lanjut/ajaxPembayaran`
                            },
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-center'
                                },
                                {
                                    data: 'jenis',
                                    name: 'jenis',
                                    className: 'text-center'
                                },
                                {
                                    data: 'tanggal',
                                    name: 'tanggal',
                                    className: 'text-center'
                                },
                                {
                                    data: 'bukti',
                                    name: 'bukti',
                                    className: 'text-center'
                                },
                                {
                                    data: 'nominal',
                                    name: 'nominal',
                                    className: 'text-center'
                                },
                                {
                                    data: 'keterangan',
                                    name: 'keterangan',
                                    className: 'text-center'
                                },
                                {
                                    data: 'date',
                                    name: 'date',
                                    className: 'text-center'
                                },
                                {
                                    data: 'action',
                                    name: 'action',
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
                                $('#dtPembayaran_info').appendTo(
                                    '#tableInfoPembayaran');
                                $('#dtPembayaran_paginate').appendTo(
                                    '#tablePaginationPembayaran');
                            }
                        });
                }
            });

            $(document).on('click', '.btn-deletePembayaran', function() {
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
                            url: `{{ url('pembayaran') }}/${id}`,
                            dataType: 'json',
                            success: function(response) {
                                $('#dtBuktiPembayaran').DataTable().ajax
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

            $('#formBuktiPembayaran').submit(function(e) {
                e.preventDefault();
                let id_tindak_lanjut = $('#id_tindak_lanjut').val();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: `{{ url('daftar-kasus') }}/${id_tindak_lanjut}/saveBuktiPembayaran`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-save-bukti-pembayaran').prop('disabled',
                            true).text(
                            'Menyimpan...');
                    },
                    success: function(response) {
                        if (response.status === false) {
                            $.each(response.error, function(key, val) {
                                $('#' + key + '_error').html(
                                    val[0]);
                            });
                        } else {
                            $('#formBuktiPembayaran')
                                .find(':input')
                                .not('#jenis_pembayaran, #id_tindak_lanjut')
                                .each(function() {
                                    switch (this.type) {
                                        case 'checkbox':
                                        case 'radio':
                                            this.checked = false;
                                            break;
                                        default:
                                            $(this).val('');
                                    }
                                });
                            $('.err').text('');
                            if ($.fn.DataTable.isDataTable('#dtBuktiPembayaran')) {
                                dtBuktiPembayaranTable.ajax
                                    .url(
                                        `{{ url('daftar-kasus') }}/${id_tindak_lanjut}/tindak_lanjut/ajaxPembayaran`
                                    )
                                    .load();
                            }
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
                        $('#btn-save-bukti-pembayaran').prop('disabled',
                                false)
                            .text(
                                'Simpan');
                    }
                });
            })

            function loadTemuan(id_tindak_lanjut) {
                $.ajax({
                    url: `{{ url('tindak_lanjut/pembayaran') }}`,
                    type: 'POST',
                    data: {
                        id_tindak_lanjut: id_tindak_lanjut,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        const kerugianPajak = res[0].rincian_keuangan
                        const kerugianDaerah = res[0].rincian_keuangan2
                        const kerugianDesa = res[0].rincian_keuangan3
                        const kerugianBlud = res[0].rincian_keuangan4
                        const pajakDibayar = res[0].setor
                        const daerahDibayar = res[0].setor2
                        const desaDibayar = res[0].setor3
                        const bludDibayar = res[0].setor4
                        const sisaPajak = res[0].rincian_keuangan
                        const sisaDaerah = res[0].rincian_keuangan2
                        const sisaDesa = res[0].rincian_keuangan3
                        const sisaBlud = res[0].rincian_keuangan4
                        $('#nilai_rugi_pajak').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(kerugianPajak));
                        $('#pajak_dibayar').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(pajakDibayar));
                        $('#sisa_pajak').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(sisaPajak));
                        $('#nilai_rugi_daerah').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(kerugianDaerah));
                        $('#daerah_dibayar').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(daerahDibayar));
                        $('#sisa_daerah').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(sisaDaerah));
                        $('#nilai_rugi_desa').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(kerugianDesa));
                        $('#desa_dibayar').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(desaDibayar));
                        $('#sisa_desa').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(sisaDesa));
                        $('#nilai_rugi_blud').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(kerugianBlud));
                        $('#blud_dibayar').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(bludDibayar));
                        $('#sisa_blud').text(
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(sisaBlud));

                        let jenis_pembayaran = $('#jenis_pembayaran').val()
                        $('#jenis_pembayaran').change(function(e) {
                            e.preventDefault();
                            jenis_pembayaran = $('#jenis_pembayaran').val()
                            if (jenis_pembayaran == 'pajak' && (parseInt(res[0]
                                    .rincian_keuangan) <= 0) || (
                                    jenis_pembayaran == 'daerah' && parseInt(
                                        res[0].rincian_keuangan2) <= 0) || (
                                    jenis_pembayaran == 'desa' && parseInt(res[0]
                                        .rincian_keuangan3) <= 0) || (
                                    jenis_pembayaran == 'blud' && parseInt(res[0]
                                        .rincian_keuangan4) <= 0)) {
                                $('.nominal_pembayaran').addClass('hidden');
                                $('.bukti_pembayaran').addClass('hidden');
                                $('.keterangan_pembayaran').addClass('hidden');
                                $('#dinamisFormPembayaran').addClass('hidden');
                            } else {
                                $('.nominal_pembayaran').removeClass('hidden');
                                $('.bukti_pembayaran').removeClass('hidden');
                                $('.keterangan_pembayaran').removeClass('hidden');
                                $('#dinamisFormPembayaran').removeClass('hidden');
                            }
                        });
                    },
                    error: function(xhr) {
                        alert('Data kerugian gagal dimuat');
                    }
                });
            }

            function loadKerugian(idTemuan) {
                $.ajax({
                    url: `{{ url('temuan/kerugian') }}`,
                    type: 'POST',
                    data: {
                        id_temuan: idTemuan,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        isiKerugian(res);
                        $('#btn-save-tindak-lanjut').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Data kerugian gagal dimuat');
                    }
                });
            }

            function isiKerugian(data) {
                setKerugian(
                    '#labelPajak',
                    '#rincianPajak',
                    '#tl_besaran_kerugian',
                    data.id_nilai_kerugian,
                    data.besaran_kerugian,
                    'Kerugian pajak tidak ditemukan'
                );
                setKerugian(
                    '#labelDaerah',
                    '#rincianDaerah',
                    '#tl_besaran_kerugian2',
                    data.id_nilai_kerugian2,
                    data.besaran_kerugian2,
                    'Kerugian daerah tidak ditemukan'
                );
                setKerugian(
                    '#labelDesa',
                    '#rincianDesa',
                    '#tl_besaran_kerugian3',
                    data.id_nilai_kerugian3,
                    data.besaran_kerugian3,
                    'Kerugian desa tidak ditemukan'
                );
                setKerugian(
                    '#labelBlud',
                    '#rincianBlud',
                    '#tl_besaran_kerugian4',
                    data.id_nilai_kerugian4,
                    data.besaran_kerugian4,
                    'Kerugian BLUD tidak ditemukan'
                );
            }

            function setKerugian(label, input, hidden, idNilai, besaran, pesan) {
                if (idNilai === null || idNilai == 0) {
                    $(label).text(pesan);
                    $(input).val(0).prop('readonly', true);
                    $(hidden).val(0);

                } else {

                    $(label).html(
                        'Besaran Kerugian : <span class="font-semibold text-error-500">Rp ' +
                        Number(besaran).toLocaleString('id-ID') +
                        '</span>'
                    );

                    $(input).prop('readonly', false);
                    $(hidden).val(besaran);

                }
            }
        });
    </script>
@endpush
