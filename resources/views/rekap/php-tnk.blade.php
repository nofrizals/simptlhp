@extends('layouts.app')

@section('title', 'Rekap PHP / TNK | SIMPTLHP')
@section('page-data', "'rekapPhpTnk'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Rekap PHP / TNK
                    </h3>
                    <p class="text-sm text-gray-500">
                        Filter dan rekapitulasi laporan hasil pemeriksaan
                    </p>
                </div>

                {{-- FILTER --}}
                <form id="formFilterRekap"
                    class="grid grid-cols-1 gap-4 border-b border-gray-200 px-6 py-5 md:grid-cols-4 lg:grid-cols-5 dark:border-gray-800">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Jenis PHP
                        </label>
                        <select name="id_jenis_php" id="id_jenis_php"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <option value="" disabled selected>Jenis PHP</option>
                            @foreach ($jenisPhpList as $jenisPhp)
                                <option value="{{ $jenisPhp->id_jenis_php }}">{{ $jenisPhp->jenis_php }}</option>
                            @endforeach
                        </select>
                        <p class="err text-theme-xs text-error-500" id="id_jenis_php_error"></p>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tahun Pemeriksaan
                        </label>
                        <select name="tahun_pemeriksaan" id="tahun_pemeriksaan"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <option value="" disabled selected>Tahun</option>
                            <option value="semua">Semua Tahun</option>
                            @foreach ($tahunPemeriksaan as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                        <p class="err text-theme-xs text-error-500" id="tahun_pemeriksaan_error"></p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama Obrik
                        </label>
                        <select name="kode_unor" id="kode_unor"
                            class="select2 dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <option value="semua" selected>Semua Obrik</option>
                            @foreach ($instansiList as $instansi)
                                <option value="{{ $instansi->kode_instansi }}">
                                    {{ strtoupper($instansi->nama_instansi) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="err text-theme-xs text-error-500" id="kode_unor_error"></p>
                    </div>

                    {{-- Disembunyikan sementara, mengikuti perilaku CI lama --}}
                    <input type="hidden" name="status_kasus" id="status_kasus" value="semua">

                    <div class="flex items-end">
                        <button type="submit" id="filterBtn"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 disabled:cursor-not-allowed disabled:bg-gray-400">
                            Cari
                        </button>
                    </div>
                </form>

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

                {{-- Datatable --}}
                <div class="overflow-x-auto">
                    <table id="dtRekap" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">#</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    No. &amp; Tgl Surat Tugas
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    Nomor LHP
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    Tanggal LHP
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    Nama Obrik
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                    Tgl Input LHP
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div id="tableFooter"
                    class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div id="tableInfo" class="text-sm text-gray-500"></div>
                    <div id="tablePagination"></div>
                </div>
            </div>

            <div id="lembarRekap"></div>
        </div>
    </div>
@endsection

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
                dataRekap: @json(route('rekap.php-tnk.data')),
                cetakPhp: @json(route('rekap.php-tnk.cetak-php', ['kasus' => '__ID__'])),
                cetakTnk: @json(route('rekap.php-tnk.cetak-tnk', ['kasus' => '__ID__'])),
                exportPhp: @json(route('rekap.php-tnk.export-php', ['kasus' => '__ID__'])),
                exportTnk: @json(route('rekap.php-tnk.export-tnk', ['kasus' => '__ID__'])),
                cetakTnkKolektif: @json(route('rekap.php-tnk.cetak-tnk-kolektif')),
                exportTnkKolektif: @json(route('rekap.php-tnk.export-tnk-kolektif')),
            };

            function clearFieldErrors() {
                $('.err').html('');
            }

            function showFieldErrors(errors) {
                clearFieldErrors();
                $.each(errors, function(key, val) {
                    $('#' + key + '_error').html(val[0]);
                });
            }

            function getFilterPayload() {
                return {
                    id_jenis_php: $('#id_jenis_php').val(),
                    tahun_pemeriksaan: $('#tahun_pemeriksaan').val(),
                    kode_unor: $('#kode_unor').val(),
                    status_kasus: $('#status_kasus').val(),
                };
            }

            $('.select2').select2();

            // LOADING
            $('#dtRekap').on('processing.dt', function(e, settings, processing) {
                $('#tableLoading').toggleClass('hidden', !processing);
            });

            const dtRekap = $('#dtRekap').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                scrollX: true,
                dom: 'rtip',
                searching: false,
                ordering: false,
                lengthChange: false,
                ajax: function(data, callback, settings) {
                    if (!$('#id_jenis_php').val() || !$('#tahun_pemeriksaan').val() || !$(
                            '#kode_unor').val()) {
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: []
                        });
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: URL.dataRekap,
                        data: Object.assign(data, getFilterPayload()),
                        dataType: 'json',
                        success: function(json) {
                            callback(json);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                                .errors) {
                                showFieldErrors(xhr.responseJSON.errors);
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                    icon: "error"
                                });
                            }
                            $('#filterBtn').prop('disabled', false).html('Cari');
                            callback({
                                draw: data.draw,
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });
                        }
                    });
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'spt',
                        name: 'spt',
                        className: 'text-center'
                    },
                    {
                        data: 'nomor_lhp_info',
                        name: 'nomor_lhp_info',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'status_info',
                        name: 'status_info',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'tanggal_lhp',
                        name: 'tanggal_lhp',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_obrik',
                        name: 'nama_obrik',
                        className: 'text-center'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center'
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
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                },
                initComplete: function() {
                    $('#dtRekap_info').appendTo('#tableInfo');
                    $('#dtRekap_paginate').appendTo('#tablePagination');
                    $('#tablePagination')
                        .addClass('flex items-center justify-end gap-2')
                        .append(`
                            <button
                                type="button"
                                id="rekapKolektifTnk"
                                class="hidden inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                title="Cetak kolektif">
                                Cetak kolektif
                            </button>
                        `);
                },
                drawCallback: function() {
                    const info = this.api().page.info();
                    const hasRows = info.recordsDisplay > 1;

                    $('#tableFooter').toggleClass('hidden', !hasRows);
                    $('#rekapKolektifTnk').toggleClass('hidden', !hasRows);
                }
            });


            // $('#customSearch').on('input', function() {
            //     dtRekap.search(this.value).draw();
            // });

            $('#pageLength').on('change', function() {
                dtRekap.page.len(this.value).draw();
            });

            $('#formFilterRekap').on('submit', function(e) {
                e.preventDefault();
                clearFieldErrors();
                $('#lembarRekap').html('');

                $('#filterBtn').prop('disabled', true).html(
                    '<span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>'
                );

                dtRekap.ajax.reload(function() {
                    $('#filterBtn').prop('disabled', false).html('Cari');
                }, true);
            });

            // TODO (Bagian C): handler tombol export Excel (#rekapphp-xlsx / #rekaptnk-xlsx).
            $(document).on('click', '.btn-cetak-php', function() {
                let idKasus = $(this).data('id');
                let url = URL.cetakPhp.replace('__ID__', idKasus);

                $('#lembarRekap').html(
                    '<div class="flex items-center justify-center py-10"><span class="w-8 h-8 border-4 border-brand-500 border-t-transparent rounded-full animate-spin"></span></div>'
                );
                $('html, body').animate({
                    scrollTop: $('#lembarRekap').offset().top - 80
                }, 300);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(res) {
                        $('#lembarRekap').html(res);
                    },
                    error: function() {
                        Swal.fire({
                            title: "Gagal",
                            text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                            icon: "error"
                        });
                        $('#lembarRekap').html('');
                    }
                });
            });

            $(document).on('click', '.btn-cetak-tnk', function() {
                let idKasus = $(this).data('id');
                let url = URL.cetakTnk.replace('__ID__', idKasus);

                $('#lembarRekap').html(
                    '<div class="flex items-center justify-center py-10"><span class="w-8 h-8 border-4 border-brand-500 border-t-transparent rounded-full animate-spin"></span></div>'
                );
                $('html, body').animate({
                    scrollTop: $('#lembarRekap').offset().top - 80
                }, 300);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(res) {
                        $('#lembarRekap').html(res);
                    },
                    error: function() {
                        Swal.fire({
                            title: "Gagal",
                            text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                            icon: "error"
                        });
                        $('#lembarRekap').html('');
                    }
                });
            });

            $(document).on('click', '#rekapKolektifTnk', function() {
                const payload = getFilterPayload();

                $('#lembarRekap').html(
                    '<div class="flex items-center justify-center py-10"><span class="w-8 h-8 border-4 border-brand-500 border-t-transparent rounded-full animate-spin"></span></div>'
                );
                $('html, body').animate({
                    scrollTop: $('#lembarRekap').offset().top - 80
                }, 300);

                $.ajax({
                    type: 'GET',
                    url: URL.cetakTnkKolektif,
                    data: {
                        id_jenis_php: payload.id_jenis_php,
                        tahun_pemeriksaan: payload.tahun_pemeriksaan,
                        kode_unor: payload.kode_unor,
                    },
                    success: function(res) {
                        $('#lembarRekap').html(res);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            showFieldErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire({
                                title: "Gagal",
                                text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                icon: "error"
                            });
                        }
                        $('#lembarRekap').html('');
                    }
                });
            });

            // Export Excel: baik #rekapphp-xlsx maupun #rekaptnk-xlsx dirender di dalam
            // partial cetak-php/cetak-tnk (delegasi event lewat document, bukan #lembarRekap,
            // supaya tetap kena walau elemen baru dimuat via AJAX).
            $(document).on('click', '#rekapphp-xlsx', function() {
                let idKasus = $(this).data('id');
                window.location.href = URL.exportPhp.replace('__ID__', idKasus);
            });

            $(document).on('click', '#rekaptnk-xlsx', function() {
                let idKasus = $(this).data('id');
                window.location.href = URL.exportTnk.replace('__ID__', idKasus);
            });

            $(document).on('click', '#rekaptnkkolektif-xlsx', function() {
                const params = new URLSearchParams({
                    id_jenis_php: $(this).data('id-jenis-php'),
                    tahun_pemeriksaan: $(this).data('tahun-pemeriksaan'),
                    kode_unor: $(this).data('kode-unor'),
                });

                window.location.href = URL.exportTnkKolektif + '?' + params.toString();
            });

            $(document).on('click', '#print', function() {
                const printContents = document.getElementById('printMe').innerHTML;
                const printWindow = window.open('', '_blank');

                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak</title>
                            <style>
                                @page { size: landscape; margin: 10mm; }
                                * { box-sizing: border-box; }
                                body {
                                    font-family: Arial, sans-serif;
                                    color: #111827;
                                    font-size: 10px;
                                }
                                table {
                                    border-collapse: collapse;
                                    width: 100%;
                                    margin-bottom: 8px;
                                }
                                table.border-0 td { border: none; }
                                td, th {
                                    padding: 3px 6px;
                                    vertical-align: middle;
                                }
                                .border,
                                table:not(.border-0) td,
                                table:not(.border-0) th {
                                    border: 1px solid #9ca3af;
                                }
                                .text-center { text-align: center; }
                                .text-right { text-align: right; }
                                .text-left { text-align: left; }
                                .font-semibold, .font-medium { font-weight: 600; }
                                h6 { margin: 2px 0; font-size: 12px; font-weight: 600; }
                                .flex { display: flex; }
                                .flex-col { flex-direction: column; }
                                .justify-between { justify-content: space-between; }
                                .mb-1, .mb-4 { margin-bottom: 8px; }
                                .py-8 { padding: 24px 0; }
                                .pr-2 { padding-right: 8px; }
                            </style>
                        </head>
                        <body>${printContents}</body>
                    </html>
                `);

                printWindow.document.close();
                printWindow.focus();

                // Tunggu render selesai sebelum memanggil print(), supaya dialog cetak
                // tidak muncul sebelum layout & style selesai di-apply oleh browser.
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.close();
                };
            });
        });
    </script>
@endpush
