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
                        <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
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
</div>

<div id="modalTindakLanjut"
    class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto p-5 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
    <div id="modalTindakLanjutContent"
        class="relative w-full max-w-[800px] scale-95 transform rounded-3xl bg-white p-6 transition-transform duration-300 dark:bg-gray-900 lg:p-10">
        <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 pb-3 pt-3">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Form TindakLanjut</h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <form id="formTindakLanjut">
                    <input type="hidden" id="id" name="id">
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
</div>
