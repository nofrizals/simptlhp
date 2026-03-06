@extends('layouts.app')

@section('title', 'Admin | SIMPTLHP')
@section('page-data', "'basicTables'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: `Admin` }">
            @include('partials.breadcrumb')
        </div>
        <div class="space-y-5 sm:space-y-6">
            <div class="relative border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <div class="flex justify-start mb-5">
                    <button id="openModalBtn"
                        class="px-4 py-3 text-sm font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                        Open Modal
                    </button>
                </div>
                <div id="tableLoading"
                    class="hidden absolute inset-0 bg-white/70 dark:bg-gray-900/70 flex items-center justify-center z-50 rounded-lg">
                    <div class="flex flex-col items-center gap-2">
                        <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-500 border-t-transparent">
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            Memuat data...
                        </span>
                    </div>
                </div>
                <table id="userTable" class="min-w-full divide-y divide-gray-200 display nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Pegawai</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Obrik</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal"
        class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-99999 hidden opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
        <div id="modalContent" class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
            <button id="closeModalBtn"
                class="absolute right-3 top-3 z-50 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                        fill="" />
                </svg>
            </button>
            <div class="rounded-2xl bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Form Tambah Admin
                    </h3>
                </div>
                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <form id="formAdmin">
                        <div class="-mx-2.5 flex flex-wrap gap-y-5">
                            <div class="w-full px-2.5">
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama OPD
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="opd"
                                        class="opd dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Pilih OPD</option>
                                        @foreach ($instansis as $instansi)
                                            <option value="{{ $instansi['kode'] }}">
                                                {{ ucwords(strtolower($instansi['nama'])) }}
                                            </option>
                                        @endforeach
                                        @foreach ($kecamatans as $kecamatan)
                                            <option value="{{ $kecamatan['kode'] }}">
                                                {{ ucwords(strtolower($kecamatan['nama'])) }}
                                            </option>
                                        @endforeach
                                        @foreach ($turunansmini as $turunanmini)
                                            <option value="{{ $turunanmini['kode'] }}">
                                                {{ ucwords(strtolower($turunanmini['nama'])) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    ID Pegawai
                                </label>
                                <input type="text" name="id_pegawai" id="id_pegawai" placeholder="Masukkan NIP/NIK"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Level
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="level" id="level"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Pilih Level</option>
                                        <option value="" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Category 1
                                        </option>
                                        <option value="" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Category 2
                                        </option>
                                        <option value="" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Category 3
                                        </option>
                                    </select>
                                    <span
                                        class="absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Password
                                </label>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>
                            <div class="w-full px-2.5">
                                <div class="mt-1 flex items-center gap-3">
                                    <button type="submit"
                                        class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                                        Save Changes
                                    </button>
                                    <button
                                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
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
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.opd').select2({
                    dropdownParent: $('#myModal'),
                    width: '100%'
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#tableLoading').removeClass('hidden');
                $("#openModalBtn").click(function() {
                    $("#myModal")
                        .removeClass("hidden opacity-0 pointer-events-none")
                        .addClass("opacity-100 pointer-events-auto");
                });
                $("#closeModalBtn, #modalCloseBtn").click(function() {
                    $("#myModal")
                        .addClass("opacity-0 pointer-events-none")
                        .removeClass("opacity-100 pointer-events-auto");
                    setTimeout(() => {
                        $("#myModal").addClass("hidden");
                    }, 300);
                });
                var table = $('#userTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        type: 'POST',
                        url: "{{ url('ajax-data-admin') }}",
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
                        }
                    ]
                });

                table.on('processing.dt', function(e, settings, processing) {
                    if (processing) {
                        $('#tableLoading').removeClass('hidden');
                    } else {
                        $('#tableLoading').addClass('hidden');
                    }
                });

                $('#btnAddAdmin').click(function(e) {
                    $('#modalAdmin').modal('show');
                    console.log('ss');
                    reset();
                });

                function reset() {
                    $('#formAdmin').trigger('reset');
                    $('.err').empty();
                }
            });
        </script>
    @endpush
@endsection
