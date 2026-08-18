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
                        <p class="text-sm text-gray-500">
                            <a href="{{ url('verifikasi-ssr') }}">
                                <u>Kembali</u>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" id="idRekomendasi" value="{{ $label }}">
                    <table class="text-sm text-gray-500">
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Oleh</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-oleh"></span>
                            </td>
                        </tr>
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
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5 align-top">Rekomendasi</td>
                            <td class="pr-2 align-top">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-rekomendasi"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Kolom Tindak Lanjut -->
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <p class="text-sm text-gray-500">
                            <u>Tindak Lanjut</u>
                        </p>
                    </div>
                </div>
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" id="id_tindak_lanjut" value="{{ $tindak_lanjut }}">
                    <table class="text-sm text-gray-500">
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Tanggal Tindak Lanjut </td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span
                                    class="info-tanggal-tindak-lanjut"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Tindak Lanjut</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-tindak-lanjut"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5">Keterangan</td>
                            <td class="pr-2">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-keterangan"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Kolom Kerugian -->
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <p class="text-sm text-gray-500">
                            <u>Kolom Kerugian</u>
                        </p>
                    </div>
                </div>
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" name="besaran_kerugian" id="tl_besaran_kerugian">
                    <input type="hidden" name="besaran_kerugian2" id="tl_besaran_kerugian2">
                    <input type="hidden" name="besaran_kerugian3" id="tl_besaran_kerugian3">
                    <input type="hidden" name="besaran_kerugian4" id="tl_besaran_kerugian4">
                    <div class="space-y-5 p-6">
                        <!-- Pajak -->
                        <div class="grid grid-cols-3 gap-4 items-start">
                            <div class="pt-7">
                                <p class="text-sm font-medium text-gray-700">
                                    Nilai Kerugian Pajak
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p id="labelPajak" class="block h-6 mb-2 text-sm text-gray-600">
                                    Kerugian pajak tidak ditemukan
                                </p>
                                <div class="flex overflow-hidden rounded-lg border border-gray-300">
                                    <span class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                        Rincian (Rp)
                                    </span>
                                    <input id="rincianPajak" name="rincian_keuangan" type="number" value="0"
                                        class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm bg-gray-50 border-r text-gray-500">
                                </div>
                                <p id="rincian_keuangan_error" class="err mt-1 text-xs text-red-500">
                                </p>
                            </div>

                        </div>
                        <!-- Daerah -->
                        <div class="grid grid-cols-3 gap-4 items-start">
                            <div class="pt-7">
                                <label class="text-sm font-medium text-gray-700">
                                    Nilai Kerugian Daerah
                                </label>
                            </div>
                            <div class="col-span-2">
                                <p id="labelDaerah" class="block h-6 mb-2 text-sm text-gray-600">
                                    Kerugian daerah tidak ditemukan
                                </p>
                                <div class="flex overflow-hidden rounded-lg border border-gray-300">
                                    <span class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                        Rincian (Rp)
                                    </span>
                                    <input id="rincianDaerah" name="rincian_keuangan2" type="number" value="0"
                                        class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm bg-gray-50 border-r text-gray-500">
                                </div>
                                <p id="rincian_keuangan2_error" class="err mt-1 text-xs text-red-500">
                                </p>
                            </div>

                        </div>
                        <!-- Desa -->
                        <div class="grid grid-cols-3 gap-4 items-start">
                            <div class="pt-7">
                                <label class="text-sm font-medium text-gray-700">
                                    Nilai Kerugian Desa
                                </label>
                            </div>
                            <div class="col-span-2">
                                <p id="labelDesa" class="block h-6 mb-2 text-sm text-gray-600">
                                    Kerugian desa tidak ditemukan
                                </p>
                                <div class="flex overflow-hidden rounded-lg border border-gray-300">
                                    <span class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                        Rincian (Rp)
                                    </span>
                                    <input id="rincianDesa" name="rincian_keuangan3" type="number" value="0"
                                        class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm bg-gray-50 border-r text-gray-500">
                                </div>
                                <p id="rincian_keuangan3_error" class="err mt-1 text-xs text-red-500">
                                </p>
                            </div>

                        </div>
                        <!-- BLUD -->
                        <div class="grid grid-cols-3 gap-4 items-start">
                            <div class="pt-7">
                                <label class="text-sm font-medium text-gray-700">
                                    Nilai Kerugian BLUD
                                </label>
                            </div>
                            <div class="col-span-2">
                                <p id="labelBlud" class="block h-6 mb-2 text-sm text-gray-600">
                                    Kerugian BLUD tidak ditemukan
                                </p>
                                <div class="flex overflow-hidden rounded-lg border border-gray-300">
                                    <span class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                        Rincian (Rp)
                                    </span>
                                    <input id="rincianBlud" name="rincian_keuangan4" type="number" value="0"
                                        class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm bg-gray-50 border-r text-gray-500">
                                </div>
                                <p id="rincian_keuangan4_error" class="err mt-1 text-xs text-red-500">
                                </p>
                            </div>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-5 flex items-center justify-between gap-3">
                            <button type="button" id="btn-cancel-tindak-lanjut"
                                class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                Tolak tindak lanjut dan beri catatan
                            </button>
                            <button type="submit" id="btn-save-tindak-lanjut"
                                class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                                Setujui tindak lanjut sudah sesuai rekomendasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 Table -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Table File -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-6">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <div>
                            <p class="text-sm text-gray-500">
                                <u>File</u>
                            </p>
                        </div>
                    </div>
                    <div id="tableLoadingFile"
                        class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Loading...
                            </span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="dtBuktiPembayaran" class="min-w-full text-sm dt-table">

                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        NO
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        FILE
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        LOG
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>

                        </table>
                    </div>
                    <div
                        class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                        <div id="tableInfoFile" class="text-sm text-gray-500">
                        </div>
                        <div id="tablePaginationFile"></div>
                    </div>
                </div>
                <!-- Table Riwayat Pembayaran -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-6">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <div>
                            <p class="text-sm text-gray-500">
                                <u>Riwayat Pembayaran</u>
                            </p>
                        </div>
                    </div>
                    <div id="tableLoadingRiwayat"
                        class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Loading...
                            </span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="dtRiwayatPembayaran" class="min-w-full text-sm dt-table">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        #
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        JENIS
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        TANGGAL
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        BUKTI
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        NOMINAL
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        KETERANGAN
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>
                        </table>
                    </div>
                    <div
                        class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                        <div id="tableInfoRiwayat" class="text-sm text-gray-500">
                        </div>
                        <div id="tablePaginationRiwayat"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            const label = $('#idRekomendasi').val();
            const id_tindak_lanjut = $('#id_tindak_lanjut').val();

            loadDetailRekomendasi(label)
            showInfoSkeleton()
            loadKerugian(id_tindak_lanjut)

            function showInfoSkeleton() {
                const skeleton =
                    '<span class="inline-block h-4 w-32 animate-pulse rounded bg-gray-200 dark:bg-gray-700"></span>';
                $('.info-oleh, .info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik, .info-jenis-php, .info-temuan, .info-penyebab, .info-rekomendasi, .info-tanggal-tindak-lanjut, .info-tindak-lanjut, .info-keterangan')
                    .html(skeleton);
            }

            function loadDetailRekomendasi(label) {
                $.ajax({
                    url: `{{ url('verifikasi-ssr/approve') }}/${label}/info`,
                    type: 'GET',
                    success: function(response) {
                        $('.info-oleh').html(response.oleh ?? '-');
                        $('.info-tanggal-lhp').html(response.tanggal_lhp ?? '-');
                        $('.info-nomor-lhp').html(response.nomor_lhp ?? '-');
                        $('.info-nama-obrik').html(response.nama_obrik ?? '-');
                        $('.info-jenis-php').html(response.jenis_php ?? '-');
                        $('.info-temuan').html(response.temuan ?? '-');
                        $('.info-penyebab').html(response.penyebab ?? '-');
                        $('.info-rekomendasi').html(response.rekomendasi ?? '-');
                        $('.info-tanggal-tindak-lanjut').html(response.tgl_tindak_lanjut ?? '-');
                        $('.info-tindak-lanjut').html(response.tindak_lanjut ?? '-');
                        $('.info-keterangan').html(response.keterangan ?? '-');
                    },
                    error: function() {
                        $('.info-tanggal-lhp, .info-nomor-lhp, .info-nama-obrik').html(
                            '<span class="text-red-500">Gagal memuat</span>');
                    }
                });
            }

            function loadKerugian(id_tindak_lanjut) {
                $.ajax({
                    url: `{{ url('verifikasi-ssr/kerugian') }}`,
                    type: 'POST',
                    data: {
                        id_tindak_lanjut: id_tindak_lanjut,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        isiKerugian(res);
                        $('#btn-save-tindak-lanjut').prop('disabled', false);
                    },
                    error: function(xhr) {
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
                    data.rincian_keuangan,
                    'Kerugian pajak tidak ditemukan'
                );
                setKerugian(
                    '#labelDaerah',
                    '#rincianDaerah',
                    '#tl_besaran_kerugian2',
                    data.id_nilai_kerugian2,
                    data.besaran_kerugian2,
                    data.rincian_keuangan2,
                    'Kerugian daerah tidak ditemukan'
                );
                setKerugian(
                    '#labelDesa',
                    '#rincianDesa',
                    '#tl_besaran_kerugian3',
                    data.id_nilai_kerugian3,
                    data.besaran_kerugian3,
                    data.rincian_keuangan3,
                    'Kerugian desa tidak ditemukan'
                );
                setKerugian(
                    '#labelBlud',
                    '#rincianBlud',
                    '#tl_besaran_kerugian4',
                    data.id_nilai_kerugian4,
                    data.besaran_kerugian4,
                    data.rincian_keuangan4,
                    'Kerugian BLUD tidak ditemukan'
                );
            }

            function setKerugian(label, input, hidden, idNilai, besaran, rincian, pesan) {
                // console.log(input);
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
                    $(input).val(rincian ?? 0);
                    $(input).prop('readonly', true);
                    $(hidden).val(besaran);
                }
            }
        });
    </script>
@endpush
