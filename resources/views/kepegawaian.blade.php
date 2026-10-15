@extends('layouts.app')

@section('title', 'Kepegawaian | SIMPTLHP')
@section('page-data', "'basicTables'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="space-y-6">
            <div
                class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            Data Kepegawaian
                        </h3>
                        <p class="text-sm text-gray-500">
                            Kelola seluruh pengguna
                        </p>
                    </div>

                    <button id="openModalBtn"
                        class="inline-flex items-center rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        + Tambah Kepegawaian
                    </button>
                </div>

                <!-- Hapus komentar jika butuh filter obrik -->
                {{-- <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
                    <form id="formFilterKepegawaian" class="grid grid-cols-1 gap-4 px-6 py-5 md:grid-cols-4 dark:border-gray-800">
                        <div class="md:col-span-3">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama Obrik
                            </label>
                            <select name="kode_unor" id="kode_unor"
                                class="select2 dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                @if ((string) session('level') === '3')
                                    <option value="{{ session('kode_unor') }}" selected>{{ session('nama_opd') }}</option>
                                @else
                                    <option value="semua" selected>Semua Obrik</option>
                                    @foreach ($instansiList as $instansi)
                                        <option value="{{ $instansi->kode_instansi }}">
                                            {{ strtoupper($instansi->nama_instansi) }}
                                        </option>
                                    @endforeach
                                @endif
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
                </div> --}}

                {{-- TOOLBAR --}}
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    {{-- SHOW --}}
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Tampilkan</span>
                        <select id="pageLength"
                            class="h-10 rounded-lg border border-gray-300 dark:border-white/90 bg-transparent px-3 py-2 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    {{-- SEARCH --}}
                    <div class="relative">
                        <input id="customSearch" type="search" placeholder="Cari pegawai..."
                            class="h-10 w-72 rounded-lg border border-gray-300 dark:border-white/90 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-0 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="relative">
                    {{-- Loading --}}
                    <div id="tableLoading"
                        class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">Loading...</span>
                        </div>
                    </div>
                    <table id="dataTable" class="min-w-full text-sm dt-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama Pegawai
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">NIP</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">NIK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Golongan &
                                    Pangkat</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">Nama OPD</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-500">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800"></tbody>
                    </table>
                </div>

                {{-- FOOTER --}}
                <div
                    class="flex flex-col gap-4 border-t border-gray-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-gray-800">
                    <div id="tableInfo" class="text-sm text-gray-500 dark:text-white/90"></div>
                    <div id="tablePagination"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
