@extends('layouts.app')

@section('title', 'Rekap APBKAM | SIMPTLHP')
@section('page-data', "'rekapApbkam'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Rekap APBKAM</h3>
                    <p class="text-sm text-gray-500">Temuan hasil pemeriksaan APBKAM per kecamatan</p>
                </div>

                <form id="formFilterApbkam"
                    class="grid grid-cols-1 gap-4 border-b border-gray-200 px-6 py-5 md:grid-cols-4 dark:border-gray-800">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tahun
                            Pemeriksaan</label>
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
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                            Kecamatan</label>
                        <select name="kode_unor" id="kode_unor"
                            class="select2 dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <option value="" disabled selected>-- Nama Kecamatan --</option>
                            @foreach ($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan->kode_unor }}">{{ strtoupper($kecamatan->nama_unor) }}</option>
                            @endforeach
                        </select>
                        <p class="err text-theme-xs text-error-500" id="kode_unor_error"></p>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" id="filterBtn"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 disabled:cursor-not-allowed disabled:bg-gray-400">
                            Cari
                        </button>
                    </div>
                </form>
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

            const URL = {
                cetak: @json(route('rekap.apbkam.cetak')),
                export: @json(route('rekap.apbkam.export')),
            };

            $('#kode_unor').select2({
                width: '100%',
                dropdownParent: $('#formFilterApbkam')
            });

            function clearFieldErrors() {
                $('.err').html('');
            }

            function showFieldErrors(errors) {
                clearFieldErrors();
                $.each(errors, function(key, val) {
                    $('#' + key + '_error').html(val[0]);
                });
            }

            $('#formFilterApbkam').on('submit', function(e) {
                e.preventDefault();
                clearFieldErrors();

                const payload = {
                    tahun_pemeriksaan: $('#tahun_pemeriksaan').val(),
                    kode_unor: $('#kode_unor').val(),
                };

                $('#filterBtn').prop('disabled', true).html(
                    '<span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>'
                );
                $('#lembarRekap').html(
                    '<div class="flex items-center justify-center py-10"><span class="w-8 h-8 border-4 border-brand-500 border-t-transparent rounded-full animate-spin"></span></div>'
                );

                $.ajax({
                    type: 'GET',
                    url: URL.cetak,
                    data: payload,
                    success: function(res) {
                        $('#lembarRekap').html(res);
                        $('html, body').animate({
                            scrollTop: $('#lembarRekap').offset().top - 80
                        }, 300);
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
                    },
                    complete: function() {
                        $('#filterBtn').prop('disabled', false).html('Cari');
                    }
                });
            });

            $(document).on('click', '#rekapapbkam-xlsx', function() {
                const params = new URLSearchParams({
                    tahun_pemeriksaan: $(this).data('tahun-pemeriksaan'),
                    kode_unor: $(this).data('kode-unor'),
                });

                window.location.href = URL.export+'?' + params.toString();
            });

            // Print — CSS eksplisit (bukan Tailwind), landscape karena tabel APBKAM sangat lebar (35 kolom).
            $(document).on('click', '#print', function() {
                const printContents = document.getElementById('printMe').innerHTML;
                const printWindow = window.open('', '_blank');

                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak</title>
                            <style>
                                @page { size: landscape; margin: 8mm; }
                                * { box-sizing: border-box; }
                                body { font-family: Arial, sans-serif; color: #111827; font-size: 9px; }
                                table { border-collapse: collapse; width: 100%; margin-bottom: 8px; }
                                table.border-0 td { border: none; }
                                td, th { padding: 2px 4px; vertical-align: middle; }
                                table:not(.border-0) td, table:not(.border-0) th { border: 1px solid #9ca3af; }
                                .text-center { text-align: center; }
                                .text-right { text-align: right; }
                                .text-left { text-align: left; }
                                .font-semibold, .font-medium { font-weight: 600; }
                                h6 { margin: 2px 0; font-size: 11px; font-weight: 600; }
                                .flex { display: flex; }
                                .flex-col { flex-direction: column; }
                                .justify-between { justify-content: space-between; }
                                .mb-1, .mb-4 { margin-bottom: 8px; }
                                .py-8 { padding: 24px 0; }
                                .pr-2 { padding-right: 8px; }
                                .bg-gray-100 { background-color: #f3f4f6; }
                            </style>
                        </head>
                        <body>${printContents}</body>
                    </html>
                `);

                printWindow.document.close();
                printWindow.focus();

                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.close();
                };
            });
        });
    </script>
@endpush
