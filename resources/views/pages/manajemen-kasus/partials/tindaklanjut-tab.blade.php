<div id="sectionTindakLanjut" class="hidden">
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            <a href="javascript:void(0)" id="btn-backToRekomendasi"
                                class="inline-flex items-center gap-2 hover:text-brand-500">
                                &larr; Daftar Tindak Lanjut
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">Kelola tindak lanjut untuk rekomendasi terpilih</p>
                    </div>
                    <button type="button" id="btn-add-tindak-lanjut"
                        class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        + Tambah Tindak Lanjut
                    </button>
                </div>
                {{-- INFO KASUS --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <input type="hidden" id="idRekomendasi" value="">
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
                        <tr>
                            <td class="whitespace-nowrap pr-2 py-0.5 align-top">Rekomendasi</td>
                            <td class="pr-2 align-top">:</td>
                            <td class="font-medium text-gray-500 dark:text-white"><span class="info-rekomendasi"></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="containerTable">
                    {{-- TOOLBAR --}}
                    <div
                        class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500">Tampilkan</span>
                            <select id="pageLengthTindakLanjut"
                                class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="relative">
                            <input id="customSearchTindakLanjut" type="text" placeholder="Cari tindak lanjut..."
                                class="h-10 w-72 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>

                    {{-- Loading --}}
                    <div id="tableLoadingTindakLanjut"
                        class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                        <div class="flex flex-col items-center gap-2">
                            <div
                                class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">Loading...</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="dtTindakLanjut" class="min-w-full text-sm dt-table">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">#</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Tanggal Tindak Lanjut
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Tindak Lanjut
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Rincian Temuan Keuangan Pajak
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Rincian Temuan Keuangan Daerah
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Rincian Temuan Keuangan Desa
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Rincian Temuan Keuangan Blud
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Status Tindak Lanjut
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                        Keterangan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Log
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
                        <div id="tableInfoTindakLanjut" class="text-sm text-gray-500"></div>
                        <div id="tablePaginationTindakLanjut"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tindak Lanjut --}}
        <div id="modalTindakLanjut"
            class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
            <div id="modalTindakLanjutContent"
                class="relative w-full max-w-[800px] rounded-3xl bg-white p-6 
            transform scale-95 transition-transform duration-300
            dark:bg-gray-900 lg:p-10">
                <button id="closeModalBtnTindakLanjut"
                    class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                            fill="" />
                    </svg>
                </button>
                <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 pb-3 pt-3">
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Form Tindak Lanjut</h3>
                    </div>
                    <div class="space-y-6 border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                        <form id="formTindakLanjut">
                            <div class="-mx-2.5 flex flex-wrap gap-y-5">
                                <input type="hidden" id="tindak_lanjut_id" name="id">
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Tgl. Tindak Lanjut <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="tgl_tindak_lanjut" id="tgl_tindak_lanjut"
                                                placeholder="Pilih tanggal SPT"
                                                class="datepickerKasus dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                            <p class="err text-theme-xs text-error-500" id="tgl_tindak_lanjut_error">
                                            </p>
                                        </div>
                                        <div class="w-1/2">
                                            <label
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Status Tindak Lanjut <span class="text-red-400">*</span>
                                            </label>
                                            <select name="id_status" id="id_status"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                                <option value="" disabled selected
                                                    class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih
                                                    OPD
                                                </option>
                                                @foreach ($status as $value)
                                                    <option value="{{ $value->id_status }}"
                                                        class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                        {{ $value->status_tl }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="err text-theme-xs text-error-500" id="id_status_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-2.5 xl:w-1/2">
                                    <div class="flex gap-3">
                                        <div class="w-1/2">
                                            <label for="tindak_lanjut"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tindak
                                                Lanjut</label>
                                            <textarea
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                name="tindak_lanjut" id="tindak_lanjut" rows="6"></textarea>
                                            <p class="err text-theme-xs text-error-500" id="tindak_lanjut_error">
                                            </p>
                                        </div>
                                        <div class="w-1/2">
                                            <label for="keterangan"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keterangan</label>
                                            <textarea
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                name="keterangan" id="keterangan" rows="6"></textarea>
                                            <p class="err text-theme-xs text-error-500" id="keterangan_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-b border-gray-200 px-6 py-3">
                                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                                        Kolom Kerugian
                                    </h3>
                                </div>
                                <input type="hidden" name="besaran_kerugian" id="tl_besaran_kerugian">
                                <input type="hidden" name="besaran_kerugian2" id="tl_besaran_kerugian2">
                                <input type="hidden" name="besaran_kerugian3" id="tl_besaran_kerugian3">
                                <input type="hidden" name="besaran_kerugian4" id="tl_besaran_kerugian4">
                                <div class="space-y-5 p-6">
                                    <!-- Pajak -->
                                    <div class="grid grid-cols-3 gap-4 items-start">
                                        <div class="pt-7">
                                            <label class="text-sm font-medium text-gray-700">
                                                Nilai Kerugian Pajak
                                            </label>
                                        </div>
                                        <div class="col-span-2">
                                            <p id="labelPajak" class="block h-6 mb-2 text-sm text-gray-600">
                                                Kerugian pajak tidak ditemukan
                                            </p>
                                            <div class="flex overflow-hidden rounded-lg border border-gray-300">
                                                <span
                                                    class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                                    Rincian (Rp)
                                                </span>
                                                <input id="rincianPajak" name="rincian_keuangan" type="number"
                                                    value="0"
                                                    class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm">
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
                                                <span
                                                    class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                                    Rincian (Rp)
                                                </span>
                                                <input id="rincianDaerah" name="rincian_keuangan2" type="number"
                                                    value="0"
                                                    class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm">
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
                                                <span
                                                    class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                                    Rincian (Rp)
                                                </span>
                                                <input id="rincianDesa" name="rincian_keuangan3" type="number"
                                                    value="0"
                                                    class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm">
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
                                                <span
                                                    class="flex w-36 items-center justify-center bg-gray-50 border-r text-gray-500">
                                                    Rincian (Rp)
                                                </span>
                                                <input id="rincianBlud" name="rincian_keuangan4" type="number"
                                                    value="0"
                                                    class="h-11 w-full border-0 focus:ring-0 focus:outline-none px-4 text-sm">
                                            </div>
                                            <p id="rincian_keuangan4_error" class="err mt-1 text-xs text-red-500">
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="w-full px-2.5">
                                    <div class="mt-1 flex items-center gap-3">
                                        <button type="submit" id="btn-save-tindak-lanjut"
                                            class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                                            Simpan
                                        </button>
                                        <button type="button" id="btn-cancel-tindak-lanjut"
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
    </div>

    {{-- Table Pembayaran --}}
    <div id="pembayaranTable" class="hidden">
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div class="space-y-6">
                <div
                    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-6">
                    <div
                        class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                Pembayaran
                            </h3>
                            <p class="text-sm text-gray-500">Riwayat pembayaran</p>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-7">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                            <!-- Card 1 -->
                            <div
                                class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] p-5">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Pajak
                                    </h3>
                                </div>
                                <div class="my-6">
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Rekomendasi Kerugian
                                        </span>
                                        <span id="nilai_rugi_pajak"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400"></span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Sudah Dibayar
                                        </span>
                                        <span id="pajak_dibayar"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400"></span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Sisa
                                        </span>
                                        <span id="sisa_pajak"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div
                                class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] p-5">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Daerah
                                    </h3>
                                </div>
                                <div class="my-6">
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Rekomendasi Kerugian
                                        </span>
                                        <span id="nilai_rugi_daerah"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Sudah Dibayar
                                        </span>
                                        <span id="daerah_dibayar"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Sisa
                                        </span>
                                        <span id="sisa_daerah"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div
                                class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] p-5">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Desa
                                    </h3>
                                </div>
                                <div class="my-6">
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Rekomendasi Kerugian
                                        </span>
                                        <span id="nilai_rugi_desa"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Sudah Dibayar
                                        </span>
                                        <span id="desa_dibayar"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Sisa
                                        </span>
                                        <span id="sisa_desa"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div
                                class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] p-5">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        BLUD
                                    </h3>
                                </div>
                                <div class="my-6">
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Rekomendasi Kerugian
                                        </span>
                                        <span id="nilai_rugi_blud"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Nilai Sudah Dibayar
                                        </span>
                                        <span id="blud_dibayar"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-b border-gray-100 py-3 dark:border-gray-800">
                                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Sisa
                                        </span>
                                        <span id="sisa_blud"
                                            class="text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
