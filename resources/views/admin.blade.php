@extends('layouts.app')

@section('title', 'Admin | SIMPTLHP')
@section('page-data', "'basicTables'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Data Admin
                        </h3>
                        <p class="text-sm text-gray-500">
                            Kelola seluruh pengguna
                        </p>
                    </div>

                    <button id="openModalBtn"
                        class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        + Tambah Admin
                    </button>
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
                        <input id="customSearch" type="text" placeholder="Cari admin..."
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

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table id="dataTable" class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">ID Pegawai
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama Lengkap
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama Obrik
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Level</th>
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

    {{-- ───── Modal Admin ───── --}}
    <div id="modalAdmin"
        class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
        <div id="modalContent" class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

            <button id="closeModalBtn"
                class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                @include('partials.icons.close')
            </button>

            <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="modal-header text-base font-medium text-gray-800 dark:text-white/90"></h3>
                </div>

                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <form id="formAdmin">
                        <div class="-mx-2.5 flex flex-wrap gap-y-5">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="simak" name="simak" value="0">
                            {{-- Tombol gunakan akun SIMAK --}}
                            <div class="w-full px-2.5">
                                <button id="openModalSimakBtn" type="button"
                                    class="shadow-theme-xs inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 py-3 w-full text-sm font-medium text-gray-700 dark:border-gray-700 dark:text-gray-400">
                                    <img src="{{ asset('images/icons/SIMAK72r.png') }}"
                                        class="h-4 w-auto opacity-80 hover:opacity-100" title="Terdaftar di SIMAK">
                                    &nbsp;Gunakan akun simak
                                </button>
                                <div class="atau flex items-center gap-4 mt-6">
                                    <div class="flex-1 h-[1px] bg-gray-200"></div>
                                    <p class="text-xm text-gray-500 whitespace-nowrap">Atau</p>
                                    <div class="flex-1 h-[1px] bg-gray-200"></div>
                                </div>
                            </div>

                            {{-- Nama OPD --}}
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                    OPD</label>
                                <select name="opd" id="opd"
                                    class="opd dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" disabled selected
                                        class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih OPD</option>
                                    @foreach ($instansis as $instansi)
                                        <option value="{{ $instansi['kode'] }}">{{ ucwords(strtolower($instansi['nama'])) }}
                                        </option>
                                    @endforeach
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan['kode'] }}">
                                            {{ ucwords(strtolower($kecamatan['nama'])) }}</option>
                                    @endforeach
                                    @foreach ($turunansmini as $turunanmini)
                                        <option value="{{ $turunanmini['kode'] }}">
                                            {{ ucwords(strtolower($turunanmini['nama'])) }}</option>
                                    @endforeach
                                </select>
                                <p class="err text-theme-xs text-error-500" id="opd_error"></p>
                            </div>

                            {{-- ID Pegawai & Nama --}}
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">ID
                                    Pegawai</label>
                                <input type="text" name="id_pegawai" id="id_pegawai" placeholder="Masukkan NIP/NIK"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="id_pegawai_error"></p>
                            </div>

                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                    Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="nama_lengkap_error"></p>
                            </div>

                            {{-- Level --}}
                            <div class="w-full px-2.5">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Level</label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="level" id="level" disabled
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih Level</option>
                                        @foreach ($levels as $lvl)
                                            <option value="{{ $lvl->tingkatan_level }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ ucwords($lvl->nama_level) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('partials.icons.chevron-down')
                                </div>
                                <p class="err text-theme-xs text-error-500" id="level_error"></p>
                            </div>

                            {{-- Tim (conditional) --}}
                            <div class="w-full px-2.5 pick-tim hidden">
                                <label
                                    class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tim</label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="tim" id="tim"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih Tim</option>
                                        @foreach ($tims as $tim)
                                            <option value="{{ $tim->id }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ $tim->name }} - {{ $tim->ketua->nama_bersih ?? 'ADMIN INFOKOM' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('partials.icons.chevron-down')
                                </div>
                                <p class="err text-theme-xs text-error-500" id="tim_error"></p>
                            </div>

                            {{-- Obrik Radio (conditional) --}}
                            <div class="w-full px-2.5 hidden" id="obrikRadio">
                                <div class="flex flex-col gap-3">
                                    <label class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Obrik Level Korwil/UPTD/Kelurahan/Kampung
                                    </label>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach ([0 => 'Tidak', 1 => 'Ya'] as $val => $label)
                                            <label
                                                class="relative flex cursor-pointer items-center gap-3 text-sm font-medium select-none">
                                                <input class="sr-only peer" type="radio" name="obrikRadio"
                                                    value="{{ $val }}">
                                                <span
                                                    class="flex h-5 w-5 items-center justify-center rounded-full border border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                    <span
                                                        class="h-2 w-2 rounded-full bg-white hidden peer-checked:block"></span>
                                                </span>
                                                {{ $label }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="err text-theme-xs text-error-500" id="obrikRadio_error"></p>
                            </div>

                            {{-- Nama Obrik (conditional) --}}
                            <div class="w-full px-2.5 hidden" id="form_nama_obrik">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                    Obrik</label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="nama_obrik" id="nama_obrik"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Nama obrik</option>
                                        @foreach ($obriks as $obrik)
                                            <option value="{{ $obrik['id'] }}" data-opd="{{ $obrik['kode_opd'] }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ $obrik['nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include('partials.icons.chevron-down')
                                </div>
                                <p class="err text-theme-xs text-error-500" id="nama_obrik_error"></p>
                            </div>

                            {{-- Password --}}
                            <div class="w-full px-2.5">
                                <label
                                    class="password mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="password_error"></p>
                                <small id="password-edit" class="hidden text-red-500">
                                    <i>Kosongkan jika tidak diubah</i>
                                </small>
                            </div>

                            {{-- Actions --}}
                            <div class="w-full px-2.5">
                                <div class="mt-1 flex items-center gap-3">
                                    <button type="submit" id="btn-save"
                                        class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                                        Simpan
                                    </button>
                                    <button type="button"
                                        class="cancel flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
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

    {{-- ───── Modal SIMAK ───── --}}
    <div id="modalSimak"
        class="fixed inset-0 flex items-start justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
        <div id="modalSimakContent"
            class="relative w-full max-w-[900px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

            <button id="closeModalSimakBtn"
                class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                @include('partials.icons.close')
            </button>

            <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="modal-header-simak text-base font-medium text-gray-800 dark:text-white/90"></h3>
                </div>
                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <div class="-mx-2.5 flex flex-wrap gap-y-5">

                        {{-- OPD SIMAK --}}
                        <div class="w-full px-2.5">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama
                                OPD</label>
                            <select id="opd_simak"
                                class="opd_simak dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                <option value="" disabled selected
                                    class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">Pilih OPD</option>
                                @foreach ($instansis as $instansi)
                                    <option value="{{ $instansi['kode'] }}">{{ ucwords(strtolower($instansi['nama'])) }}
                                    </option>
                                @endforeach
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan['kode'] }}">
                                        {{ ucwords(strtolower($kecamatan['nama'])) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tabel SIMAK (awalnya tersembunyi) --}}
                        <div class="w-full px-2.5 hidden" id="simakTableWrapper">
                            <table id="simakTable" class="min-w-full divide-y divide-gray-200 display nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                // ─── Global AJAX setup ──────────────────────────────────────────
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // ─── Konstanta URL ───────────────────────────────────────────────
                const URL = {
                    ajaxAdmin: "{{ url('ajax-data-admin') }}",
                    storeAdmin: "{{ url('admin') }}",
                    ajaxSimak: "{{ url('ajax-data-simak') }}",
                    turunanOpd: "{{ url('instansi/getMyTurunan') }}",
                };

                // ─── Spinner HTML ────────────────────────────────────────────────
                const SPINNER_HTML = `
                        <svg aria-hidden="true" class="w-5 h-5 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span>Loading...</span>`;

                // ════════════════════════════════════════════════════════════════
                // DATATABLE UTAMA
                // ════════════════════════════════════════════════════════════════

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
                        url: URL.ajaxAdmin
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'id_pegawai',
                            name: 'id_pegawai',
                            className: 'text-left'
                        },
                        {
                            data: 'nama_pegawai',
                            name: 'nama_pegawai',
                            className: 'text-left'
                        },
                        {
                            data: 'nama_obrik',
                            name: 'nama_obrik',
                            className: 'text-left'
                        },
                        {
                            data: 'level',
                            name: 'level',
                            className: 'text-left'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
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

                // ════════════════════════════════════════════════════════════════
                // MODAL ADMIN — Helper
                // ════════════════════════════════════════════════════════════════
                function openModalAdmin() {
                    resetAdminForm();
                    initSelect2Admin();
                    $('#modalAdmin').removeClass('opacity-0 pointer-events-none');
                    $('#modalContent').removeClass('scale-95').addClass('scale-100');
                }

                function closeModalAdmin() {
                    $('#modalAdmin').addClass('opacity-0 pointer-events-none');
                    $('#modalContent').removeClass('scale-100').addClass('scale-95');
                }

                function initSelect2Admin() {
                    if (!$('#opd').hasClass('select2-hidden-accessible')) {
                        $('#opd').select2({
                            dropdownParent: $('#modalAdmin'),
                            width: '100%'
                        });
                    }
                }

                function resetAdminForm() {
                    $('#formAdmin')[0].reset();
                    $('#id').val('');
                    $('.err').empty();
                    $('#opd, #level, #tim, #nama_obrik').prop('selectedIndex', 0);
                    $('#level').prop('disabled', true);
                    $('.pick-tim, #obrikRadio, #form_nama_obrik').addClass('hidden');
                    $('input[name="obrikRadio"][value="0"]').prop('checked', true);
                    $('#password-edit').addClass('hidden');
                    $('#password').closest('.w-full').addClass('show');
                    $('.password').show();
                    $('.atau').show();
                    $('#openModalSimakBtn').show();
                    // Reset select2 jika sudah diinisialisasi
                    if ($('#opd').hasClass('select2-hidden-accessible')) {
                        $('#opd').val(null).trigger('change');
                    }
                    setModeManual();
                }

                function setModeSimak() {
                    // Sembunyikan elemen yang tidak relevan untuk SIMAK
                    $('#openModalSimakBtn').closest('.w-full').addClass('hidden');
                    $('#password').closest('.w-full').addClass('hidden');
                    $('.password').hide();
                    $('.atau').hide();
                    $('#openModalSimakBtn').hide();
                    $('#password').val('').removeAttr('required');
                }

                function setModeManual() {
                    // Tampilkan kembali semua elemen
                    $('#openModalSimakBtn').closest('.w-full').removeClass('hidden');
                    $('#password').closest('.w-full').removeClass('hidden');
                }

                // ════════════════════════════════════════════════════════════════
                // MODAL SIMAK — Helper
                // ════════════════════════════════════════════════════════════════
                function openModalSimak() {
                    resetSimakForm();
                    initSelect2Simak();
                    $('#modalSimak').removeClass('opacity-0 pointer-events-none');
                    $('#modalSimakContent').removeClass('scale-95').addClass('scale-100');
                }

                function closeModalSimak() {
                    $('#modalSimak').addClass('opacity-0 pointer-events-none');
                    $('#modalSimakContent').removeClass('scale-100').addClass('scale-95');
                }

                function initSelect2Simak() {
                    if (!$('#opd_simak').hasClass('select2-hidden-accessible')) {
                        $('#opd_simak').select2({
                            dropdownParent: $('#modalSimak'),
                            width: '100%'
                        });
                    }
                }

                function resetSimakForm() {
                    $('#opd_simak').val(null).trigger('change');
                    $('#simakTableWrapper').addClass('hidden');

                    // Destroy DataTable simak jika ada agar bisa di-init ulang dengan OPD baru
                    if ($.fn.DataTable.isDataTable('#simakTable')) {
                        $('#simakTable').DataTable().destroy();
                        $('#simakTable tbody').empty();
                    }
                }

                // ════════════════════════════════════════════════════════════════
                // EVENT: Buka/Tutup Modal
                // ════════════════════════════════════════════════════════════════
                $('#openModalBtn').on('click', function() {
                    $('.modal-header').text('Form Tambah Admin');
                    openModalAdmin();
                });

                $('#closeModalBtn, .cancel').on('click', function() {
                    closeModalAdmin();
                });

                $('#openModalSimakBtn').on('click', function() {
                    $('.modal-header-simak').text('Pilih Pegawai SIMAK');
                    openModalSimak();
                });

                $('#closeModalSimakBtn').on('click', function() {
                    closeModalSimak();
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: OPD Change → Enable Level
                // ════════════════════════════════════════════════════════════════
                $('#opd').on('change', function() {
                    $('#level').prop('disabled', false);
                    const opd = $(this).val();
                    // Filter opsi nama_obrik berdasarkan OPD
                    $('#nama_obrik option').hide();
                    $('#nama_obrik option[data-opd="' + opd + '"]').show();
                    $('#nama_obrik').val('');
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: Level Change → Conditional Fields
                // ════════════════════════════════════════════════════════════════
                $('#level').on('change', function() {
                    const kodeUnor = $('#opd').val();
                    if (!kodeUnor) {
                        $(this).val('').trigger('change');
                        return;
                    }

                    const level = parseInt($(this).val());
                    const kode = parseInt(kodeUnor.substring(3, 5));
                    const isObrik = (level === 3 && ((kode >= 32 && kode <= 45) || kode === 13 || kode === 23));

                    $('#obrikRadio').toggleClass('hidden', !isObrik);
                    $('.pick-tim').toggleClass('hidden', !(!isObrik && level === 2));
                    $('input[name="obrikRadio"][value="0"]').prop('checked', true).trigger('change');
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: Obrik Radio Change → Load Turunan
                // ════════════════════════════════════════════════════════════════
                $(document).on('change', 'input[name="obrikRadio"]', function() {
                    if ($(this).val() !== '1') {
                        $('#form_nama_obrik').addClass('hidden');
                        $('#nama_obrik').html('<option disabled selected>--pilih</option>');
                        return;
                    }

                    const opd = $('#opd').val();
                    $('#form_nama_obrik').removeClass('hidden');

                    $.ajax({
                        type: 'POST',
                        url: URL.turunanOpd,
                        dataType: 'json',
                        data: {
                            id: opd
                        },
                        success(res) {
                            let html = '<option disabled selected>--pilih</option>';
                            if (res.data?.length) {
                                res.data.forEach(row => {
                                    const selected = row.kode_turunan === opd ? 'selected' : '';
                                    html +=
                                        `<option value="${row.kode_turunan}" ${selected}>${row.nama_instansi}</option>`;
                                });
                            }
                            $('#nama_obrik').html(html);
                        },
                        error() {
                            $('#nama_obrik').html('<option disabled selected>--pilih</option>');
                        }
                    });
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: OPD SIMAK Change → Load DataTable SIMAK
                // ════════════════════════════════════════════════════════════════
                $('#opd_simak').on('change', function() {
                    const opdSimak = $(this).val();
                    if (!opdSimak) return;

                    // Destroy dulu jika sudah pernah di-init
                    if ($.fn.DataTable.isDataTable('#simakTable')) {
                        $('#simakTable').DataTable().destroy();
                        $('#simakTable tbody').empty();
                    }

                    $('#simakTableWrapper').removeClass('hidden');

                    $('#simakTable').DataTable({
                        responsive: true,
                        serverSide: true,
                        processing: true,
                        ajax: {
                            type: 'POST',
                            url: URL.ajaxSimak,
                            data: {
                                opd: opdSimak
                            },
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'nama_pegawai',
                                name: 'nama_pegawai',
                                className: 'text-left'
                            },
                            {
                                data: 'jabatan',
                                name: 'jabatan',
                                className: 'text-left',
                                orderable: false
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: Pilih Pegawai SIMAK → Populate & Buka Modal Admin
                // ════════════════════════════════════════════════════════════════
                $(document).on('click', '.btn-pickSimak', function() {
                    const nip = $(this).data('nip');
                    const nama = $(this).data('nama');
                    const kodeUnor = $(this).data('kode_unor');
                    const kodeOpd = String(kodeUnor).substring(0, 5);

                    // Verifikasi OPD ada di dropdown
                    const optionExists = $('#opd option[value="' + kodeOpd + '"]').length > 0;
                    if (!optionExists) {
                        Swal.fire({
                            title: 'Perhatian',
                            text: `OPD dengan kode ${kodeOpd} tidak tersedia di daftar. Silakan pilih OPD secara manual.`,
                            icon: 'warning',
                        });
                    }

                    // 1. Tutup modal SIMAK
                    closeModalSimak();

                    // 2. Reset & buka modal Admin
                    resetAdminForm();
                    $('.modal-header').text('Form Tambah User SIMAK');
                    openModalAdmin();

                    // 4. Sembunyikan elemen tidak relevan untuk SIMAK
                    setModeSimak();

                    // 5. Populate field otomatis
                    $('#simak').val('1');
                    $('#id_pegawai').val(nip);
                    $('#nama_lengkap').val(nama);

                    // 6. Set OPD via Select2
                    initSelect2Admin();
                    $('#opd').val(kodeOpd).trigger('change');

                    // 7. Level kosong, user pilih sendiri
                    $('#level').val('').prop('disabled', false);
                });

                // ════════════════════════════════════════════════════════════════
                // FORM SUBMIT: Tambah / Edit Admin
                // ════════════════════════════════════════════════════════════════
                $('#formAdmin').on('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this); // ← Fix: const, bukan implicit global

                    $.ajax({
                        type: 'POST',
                        url: URL.storeAdmin,
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        beforeSend() {
                            $('.err').html('');
                            $('#btn-save').prop('disabled', true).html(SPINNER_HTML);
                        },
                        success(response) {
                            if (!response) {
                                return Swal.fire({
                                    title: 'Gagal',
                                    text: 'Response server tidak valid',
                                    icon: 'error'
                                });
                            }

                            closeModalAdmin();
                            dataTable.ajax.reload(null, false);
                            Swal.fire({
                                title: 'Sukses',
                                text: response.message,
                                icon: 'success'
                            });
                        },
                        error(xhr) {
                            if (xhr.status === 422) {
                                // Fix: response.errors bukan response.error
                                $.each(xhr.responseJSON.errors, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                                return;
                            }
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi kesalahan server',
                                icon: 'error'
                            });
                        },
                        complete() {
                            $('#btn-save').prop('disabled', false).html('Simpan');
                        }
                    });
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: Edit Admin
                // ════════════════════════════════════════════════════════════════
                $(document).on('click', '.btn-editAdmin', function() {
                    const data = $(this).data();

                    openModalAdmin();
                    $('.modal-header').text('Form Edit Admin');

                    $('#id').val(data.id);
                    $('#id_pegawai').val(data.id_pegawai);
                    $('#nama_lengkap').val(data.nama);
                    $('#password-edit').removeClass('hidden');

                    // Select2: set setelah init
                    initSelect2Admin();
                    $('#opd').val(data.opd).trigger('change');
                    $('#level').val(data.level).prop('disabled', false).trigger('change');

                    if (data.level == 2) {
                        $('#tim').val(data.tim);
                    }
                    if (data.nama_obrik) {
                        $('#nama_obrik').val(data.nama_obrik);
                    }
                });

                // ════════════════════════════════════════════════════════════════
                // EVENT: Hapus Admin
                // ════════════════════════════════════════════════════════════════
                $(document).on('click', '.btn-deleteAdmin', function() {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#DC3545',
                        confirmButtonColor: '#28A745',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Yakin',
                        reverseButtons: true,
                    }).then(result => {
                        if (!result.isConfirmed) return;

                        $.ajax({
                            type: 'DELETE',
                            url: `${URL.storeAdmin}/${id}`,
                            dataType: 'json',
                            success(response) {
                                if (!response.status) {
                                    return Swal.fire({
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan pada server.',
                                        icon: 'error'
                                    });
                                }
                                dataTable.ajax.reload(function() {
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: response.message,
                                        icon: 'success'
                                    });
                                }, false);
                            },
                            error() {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan server.',
                                    icon: 'error'
                                });
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
