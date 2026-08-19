@extends('layouts.app')

@section('title', 'Approval Tindak Lanjut SSR | SIMPTLHP')
@section('page-data', "'verifikasi-ssr'")

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
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
                        @if (Route::is('verifikasi-ssr.approve'))
                            <div class="pt-5 flex items-center justify-between gap-3">
                                <button type="button" id="btn-modal-tolak"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    Tolak tindak lanjut dan beri catatan
                                </button>
                                <button type="button" id="btn-setujui"
                                    class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                                    Setujui tindak lanjut sudah sesuai rekomendasi
                                </button>
                            </div>
                        @else
                            @if ($reject)
                                <div
                                    class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
                                    <div class="flex items-start gap-3">
                                        <div class="-mt-0.5 text-error-500">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753L11.9998 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753L12.0008 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898L12.7498 13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555L11.2498 7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z"
                                                    fill="#F04438" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                                Ditolak pada
                                                {{ Carbon::parse($reject_at ?? '-')->translatedFormat('d F Y') }}
                                            </h4>
                                            <p class="catatan text-sm text-gray-500 dark:text-gray-400"><b>Catatan:
                                                </b>{{ $catatan }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
                                    <div class="flex items-start gap-3">
                                        <div class="-mt-0.5 text-success-500">
                                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z"
                                                    fill="" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                                Disetujui pada
                                                {{ Carbon::parse($approve_at ?? '-')->translatedFormat('d F Y') }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endif
                    </div>
                </div>
            </div>

            <!-- 2 Table -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Table File -->
                <div
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-6 lg:col-span-2">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <div>
                            <p class="text-sm text-gray-500">
                                <u>File</u>
                            </p>
                        </div>
                    </div>
                    <div id="tableLoadingFile"
                        class="absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
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
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        NO
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                                        FILE
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">
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
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-6 lg:col-span-3">
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

        <!-- Modal -->
        <div id="modal"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-5 opacity-0 pointer-events-none transition-opacity duration-300">
            <!-- Overlay -->
            <div class="fixed inset-0 h-full w-full bg-black/30 backdrop-blur-sm"></div>
            <!-- Modal -->
            <div id="modalContent"
                class="relative w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl transform scale-95 transition-transform duration-300 dark:bg-gray-900 sm:p-8">
                <!-- Close -->
                <button id="closeModalBtn"
                    class="absolute right-4 top-4 z-50 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                            fill="" />
                    </svg>
                </button>
                <!-- Header -->
                <div class="border-b border-gray-200 pb-4 dark:border-gray-800">
                    <h3 class="modal-header text-lg font-semibold text-gray-800 dark:text-white/90"></h3>
                </div>
                <!-- Body -->
                <div class="pt-6">
                    <form id="formTolak">
                        <div>
                            <label for="catatan" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Catatan
                                <span class="text-red-400">*</span>
                            </label>
                            <textarea
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                name="catatan" id="catatan" rows="6" placeholder="Berikan catatan"></textarea>
                            <p class="err text-theme-xs text-error-500" id="catatan_error"></p>
                        </div>
                        <!-- Footer -->
                        <div class="mt-6 flex items-center justify-end gap-3">
                            <button type="submit" id="btn-tolak"
                                class="bg-red-500 hover:bg-red-600 flex items-center justify-center gap-2 rounded-lg px-5 py-2.5 text-sm font-medium text-white">
                                Tolak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

            dtRiwayatPembayaranTable = $('#dtRiwayatPembayaran').DataTable({
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
                    url: `{{ url('verifikasi-ssr') }}/${id_tindak_lanjut}/ajaxRiwayatPembayaran`,
                    beforeSend: function() {
                        $('#tableLoadingRiwayat').removeClass('hidden');
                    },

                    complete: function() {
                        $('#tableLoadingRiwayat').addClass('hidden');
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
                    $('#dtRiwayatPembayaran_info').appendTo('#tableInfoRiwayat');
                    $('#dtRiwayatPembayaran_paginate').appendTo('#tablePaginationRiwayat');
                }
            });

            dtBuktiPembayaranTable = $('#dtBuktiPembayaran').DataTable({
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
                    url: `{{ url('verifikasi-ssr') }}/${id_tindak_lanjut}/ajaxBuktiPembayaran`,
                    beforeSend: function() {
                        $('#tableLoadingFile').removeClass('hidden');
                    },

                    complete: function() {
                        $('#tableLoadingFile').addClass('hidden');
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
                        data: 'file',
                        name: 'file',
                        className: 'text-center'
                    },
                    {
                        data: 'log',
                        name: 'log',
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
                    $('#dtBuktiPembayaran_info').appendTo('#tableInfoFile');
                    $('#dtBuktiPembayaran_paginate').appendTo('#tablePaginationFile');
                }
            });

            function openModal() {
                reset();
                $('#modal')
                    .removeClass('pointer-events-none opacity-0');

                $('#modalContent')
                    .removeClass('scale-95')
                    .addClass('scale-100');
            }

            $('#btn-modal-tolak').click(function() {
                $('.modal-header').html('Tolak Tindak Lanjut SSR');
                openModal();
            });

            $('#formTolak').submit(function(e) {
                e.preventDefault();
                const id = $('#id_tindak_lanjut').val();
                if (!id) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Tindak lanjut tidak ditemukan',
                        icon: 'error'
                    });
                    return;
                }

                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: `{{ url('verifikasi-ssr') }}/${id}/tolak-ssr`,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.err').html('');
                        $('#btn-tolak')
                            .prop('disabled', true)
                            .html('Loading...');
                        $('#closeModalBtn')
                            .prop('disabled', true);
                    },

                    success: function(response) {
                        if (!response) {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Response server tidak valid',
                                icon: 'error'
                            });
                            return;
                        }
                        if (response.status === false) {
                            $.each(response.error, function(key, val) {
                                $('#' + key + '_error').html(val[0]);
                            });
                        } else {
                            closeModal();
                            Swal.fire({
                                title: 'Sukses',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.href = "{{ url('verifikasi-ssr') }}";
                            });
                            reset();
                        }
                    },

                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Terjadi kesalahan server',
                            icon: 'error'
                        });
                    },

                    complete: function() {
                        $('#btn-tolak')
                            .prop('disabled', false)
                            .html('Tolak');
                        $('#closeModalBtn')
                            .prop('disabled', false);
                    }
                });
            });

            $("#closeModalBtn").click(function() {
                reset();
                closeModal();
            });

            $('#btn-setujui').click(function() {
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
                        const id = $('#id_tindak_lanjut').val();
                        $.ajax({
                            type: "POST",
                            url: `{{ url('verifikasi-ssr') }}/${id}/setujui`,
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.href = response
                                            .redirect;
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Gagal",
                                        text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Gagal",
                                    text: xhr.responseJSON?.message ??
                                        "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                    icon: "error"
                                });

                            }
                        });
                    }
                })
            });

            function closeModal() {
                $('#modal').addClass('opacity-0 pointer-events-none');
                $('#modalContent').removeClass('scale-100').addClass('scale-95');
            }

            function reset() {
                $('#formTolak')[0].reset();
                $('#formTolak .err').empty();
            }
        });
    </script>
@endpush
