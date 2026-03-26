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
                        Tambah
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
    <div id="modalAdmin"
        class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-50 hidden opacity-0 pointer-events-none transition-opacity duration-300">
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
                                    <select name="opd" id="opd"
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
                                <p class="err text-theme-xs text-error-500" id="opd_error"></p>
                            </div>
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    ID Pegawai
                                </label>
                                <input type="text" name="id_pegawai" id="id_pegawai" placeholder="Masukkan NIP/NIK"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="id_pegawai_error"></p>
                            </div>
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="nama_lengkap_error"></p>
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Level
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="level" id="level"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        disabled>
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Pilih Level</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->tingkatan_level }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ ucwords($level->nama_level) }}
                                            </option>
                                        @endforeach
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
                                <p class="err text-theme-xs text-error-500" id="level_error"></p>
                            </div>
                            <div class="w-full px-2.5 pick-tim hidden">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Tim
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="tim" id="tim"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Pilih Tim</option>
                                        @foreach ($tims as $tim)
                                            <option value="{{ $tim->id }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ $tim->name }} - {{ $tim->ketua->nama_pegawai ?? 'ADMIN INFOKOM' }}
                                            </option>
                                        @endforeach
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
                                <p class="err text-theme-xs text-error-500" id="tim_error"></p>
                            </div>
                            <div class="w-full px-2.5 hidden" id="obrikRadio">
                                <div class="flex flex-col gap-3" x-data="{ isChecked: 'Tidak' }">
                                    <label class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Obrik Level Korwil/UPTD/Kelurahan/Kampung
                                    </label>
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div>
                                            <label
                                                :class="isChecked === 'Tidak' ? 'text-gray-700 dark:text-gray-400' :
                                                    'text-gray-500 dark:text-gray-400'"
                                                class="relative flex cursor-pointer items-center gap-3 text-sm font-medium select-none">
                                                <input class="sr-only" type="radio" name="obrikRadio" value="0"
                                                    @change="isChecked = 'Tidak'" />
                                                <span
                                                    :class="isChecked === 'Tidak' ? 'border-brand-500 bg-brand-500' :
                                                        'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                                                    <span :class="isChecked === 'Tidak' ? 'block' : 'hidden'"
                                                        class="h-2 w-2 rounded-full bg-white"></span>
                                                </span>
                                                Tidak
                                            </label>
                                        </div>
                                        <div>
                                            <label
                                                :class="isChecked === 'Ya' ? 'text-gray-700 dark:text-gray-400' :
                                                    'text-gray-500 dark:text-gray-400'"
                                                class="relative flex cursor-pointer items-center gap-3 text-sm font-medium select-none">
                                                <input class="sr-only" type="radio" name="obrikRadio" value="1"
                                                    @change="isChecked = 'Ya'" />
                                                <span
                                                    :class="isChecked === 'Ya' ? 'border-brand-500 bg-brand-500' :
                                                        'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                                                    <span :class="isChecked === 'Ya' ? 'block' : 'hidden'"
                                                        class="h-2 w-2 rounded-full bg-white"></span>
                                                </span>
                                                Ya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <p class="err text-theme-xs text-error-500" id="obrikRadio_error"></p>
                            </div>
                            <div class="w-full px-2.5 hidden" id="form_nama_obrik">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Nama Obrik
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select name="nama_obrik" id="nama_obrik"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                        <option value="" disabled selected
                                            class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                            Nama obrik</option>
                                        @foreach ($obriks as $obrik)
                                            <option value="{{ $obrik['id'] }}" data-opd="{{ $obrik['kode_opd'] }}"
                                                class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                                {{ $obrik['nama'] }}
                                            </option>
                                        @endforeach
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
                                <p class="err text-theme-xs text-error-500" id="nama_obrik_error"></p>
                            </div>
                            <div class="w-full px-2.5">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Password
                                </label>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="password_error"></p>
                            </div>
                            <div class="w-full px-2.5">
                                <div class="mt-1 flex items-center gap-3">
                                    <button type="submit" id="btn-save"
                                        class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                                        Simpan
                                    </button>
                                    <button type="button"
                                        class="cancel flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#tableLoading').removeClass('hidden');

                $("#openModalBtn").click(function() {
                    if (!$('.opd').hasClass("select2-hidden-accessible")) {
                        $('.opd').select2({
                            dropdownParent: $('#modalAdmin'),
                            width: '100%'
                        });
                    }
                    $("#modalAdmin").removeClass("hidden opacity-0 pointer-events-none").addClass(
                        "opacity-100 pointer-events-auto");
                });

                $("#closeModalBtn").click(function() {
                    reset();
                    $("#modalAdmin").addClass("opacity-0 pointer-events-none").removeClass(
                        "opacity-100 pointer-events-auto");
                });

                var table = $('#userTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: false,
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

                $('#formAdmin').submit(function(e) {
                    e.preventDefault();
                    formData = new FormData($('#formAdmin')[0]);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin') }}",
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.err').html('');
                            let loading = `<svg aria-hidden="true" class="w-5 h-5 text-neutral-tertiary animate-spin fill-brand" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Loading...</span>`
                            $('#btn-save').prop('disabled', true).addClass(
                                'disabled:bg-gray-400 disabled:cursor-not-allowed').html(
                                loading);
                        },

                        success: function(response) {
                            console.log(response);
                            if (!response) {
                                notif('error', 'Response server tidak valid');
                                return;
                            }
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                $('#modalAdmin').addClass('hidden opacity-0 pointer-events-none');
                                if ($.fn.DataTable.isDataTable('#userTable')) {
                                    $('#userTable').DataTable().ajax.reload(null, true);
                                }
                                notif('success', response.message);
                                reset();
                                $('.pick-tim').addClass('hidden');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            notif('error', 'Terjadi kesalahan server');
                        },
                        complete: function() {
                            $('#btn-save')
                                .prop('disabled', false)
                                .html('Simpan');
                        }
                    });
                });

                $('#level').change(function() {
                    let kode_unor = $('#opd').val();
                    // jika opd belum dipilih
                    if (!kode_unor) {
                        // reset level
                        $(this).val('').trigger('change');
                        return;
                    }
                    let level = $(this).val();
                    console.log(level);

                    let kode = parseInt(kode_unor.substring(3, 5));
                    let isObrik = (level == 3 && ((kode >= 32 && kode <= 45) || kode == 13 || kode == 23));

                    if (isObrik) {
                        $('#obrikRadio').removeClass('hidden');
                        $('.pick-tim').addClass('hidden');
                    } else {
                        $('#obrikRadio').addClass('hidden');

                        if (level == 2) {
                            $('.pick-tim').removeClass('hidden');
                        } else {
                            $('.pick-tim').addClass('hidden');
                        }
                    }

                    $('input[name=obrikRadio][value="0"]').prop('checked', true).trigger('change');
                });

                $(document).on('change', 'input[name=obrikRadio]', function() {
                    const opd = $('#opd').val();
                    if ($(this).val() != 1) {
                        $("#form_nama_obrik").addClass('hidden');
                        $('#nama_obrik').html('<option disabled selected>--pilih</option>');
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ url('instansi/getMyTurunan') }}",
                        dataType: "json",
                        data: {
                            id: opd
                        },

                        beforeSend() {
                            $("#form_nama_obrik").removeClass('hidden');
                        },

                        success(res) {
                            let html = '<option disabled selected>--pilih</option>';
                            if (res.data?.length) {
                                res.data.forEach(row => {
                                    let selected = row.kode_turunan == opd ?
                                        'selected' : '';
                                    html += `<option value="${row.kode_turunan}" ${selected}>
                                ${row.nama_instansi}
                             </option>`;
                                });
                            }
                            $('#nama_obrik').html(html);
                        },
                        error() {
                            $('#nama_obrik').html(
                                '<option disabled selected>--pilih</option>');
                        }
                    });
                });

                $('#opd').on('change', function() {
                    $('#level').prop('disabled', false);
                    let opd = $(this).val();
                    $('#nama_obrik option').hide();
                    $('#nama_obrik option[data-opd="' + opd + '"]').show();
                    $('#nama_obrik').val('');
                });

                $('.cancel').click(function(e) {
                    e.preventDefault();
                    reset();
                    $('#modalAdmin').addClass('hidden opacity-0 pointer-events-none');
                });

                function reset() {
                    $('#formAdmin')[0].reset();
                    $('.err').empty();
                }
            });
        </script>
    @endpush
@endsection
