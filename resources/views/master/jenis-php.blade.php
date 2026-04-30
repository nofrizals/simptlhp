@extends('layouts.app')

@section('title', 'Jenis PHP | SIMPTLHP')
@section('page-data', "'jenis-php'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: `Jenis PHP` }">
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
                <table id="jenisPhpTable" class="min-w-full divide-y divide-gray-200 display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis PHP</th>
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
    <div id="modalJenisPHP"
        class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 h-full w-full bg-black/10 backdrop-blur-xs"></div>
        <div id="modalContent"
            class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 
            transform scale-95 transition-transform duration-300
            dark:bg-gray-900 lg:p-10">
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
                    <h3 class="modal-header text-base font-medium text-gray-800 dark:text-white/90"></h3>
                </div>
                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <form id="formJenisPHP">
                        <div class="-mx-2.5 flex flex-wrap gap-y-5">
                            <input type="hidden"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                id="id" name="id">
                            <div class="w-full px-2.5 xl:w-1/2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Jenis PHP
                                </label>
                                <input type="text" name="jenis_php" id="jenis_php" placeholder="Jenis PHP"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <p class="err text-theme-xs text-error-500" id="jenis_php_error"></p>
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

                function openModal() {
                    $('#modalJenisPHP')
                        .removeClass('pointer-events-none opacity-0');

                    $('#modalContent')
                        .removeClass('scale-95')
                        .addClass('scale-100');
                }

                function closeModal() {
                    $('#modalJenisPHP')
                        .addClass('opacity-0 pointer-events-none');

                    $('#modalContent')
                        .removeClass('scale-100')
                        .addClass('scale-95');
                }

                $("#openModalBtn").click(function() {
                    $('.modal-header').html('Form Tambah Jenis PHP');
                    if (!$('.opd').hasClass("select2-hidden-accessible")) {
                        $('.opd').select2({
                            dropdownParent: $('#modalJenisPHP'),
                            width: '100%'
                        });
                    }
                    openModal();
                });

                $("#closeModalBtn").click(function() {
                    reset();
                    closeModal();
                });

                var table = $('#jenisPhpTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        type: 'POST',
                        url: "{{ url('ajax-data-jenis-php') }}",
                        error: function() {
                            $('#tableLoading').addClass('hidden');
                            Swal.fire({
                                title: "Gagal",
                                text: "Gagal memuat data",
                                icon: "error"
                            });
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
                            data: 'jenis_php',
                            name: 'jenis_php',
                            className: 'text-center'
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

                $('#formJenisPHP').submit(function(e) {
                    e.preventDefault();
                    let formData = new FormData($('#formJenisPHP')[0]);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('jenis-php') }}",
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
                            if (!response) {
                                Swal.fire({
                                    title: "Gagal",
                                    text: "Response server tidak valid",
                                    icon: "error"
                                });
                                return;
                            }
                            if (response.status === false) {
                                $.each(response.error, function(key, val) {
                                    $('#' + key + '_error').html(val[0]);
                                });
                            } else {
                                closeModal();
                                if ($.fn.DataTable.isDataTable('#jenisPhpTable')) {
                                    $('#jenisPhpTable').DataTable().ajax.reload(null,
                                        false);
                                }
                                Swal.fire({
                                    title: "Sukses",
                                    text: response.message,
                                    icon: "success"
                                });
                                reset();
                                $('.pick-tim').addClass('hidden');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Terjadi kesalahan server",
                                icon: "error"
                            });
                        },
                        complete: function() {
                            $('#btn-save')
                                .prop('disabled', false)
                                .html('Simpan');
                        }
                    });
                });

                $(document).on('click', '.btn-deleteJenisPHP', function() {
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
                            let id = $(this).data('id');
                            $.ajax({
                                type: "delete",
                                url: "{{ url('jenis-php') }}/" + id,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status) {
                                        $('#jenisPhpTable').DataTable().ajax.reload(
                                            function() {
                                                Swal.fire({
                                                    title: "Sukses",
                                                    text: response.message,
                                                    icon: "success"
                                                });
                                            }, false);
                                    } else {
                                        Swal.fire({
                                            title: "Gagal",
                                            text: "Terjadi kesalahan pada server. Coba lagi dalam beberapa saat.",
                                            icon: "error"
                                        });
                                    }
                                }
                            });
                        }
                    })
                });

                $(document).on('click', '.btn-editJenisPHP', function() {
                    let data = $(this).data();
                    openModal();
                    $('.modal-header').html(
                        'Form Edit Jenis PHP');
                    $('#id').val(data.id);
                    $('#jenis_php').val(data.jenis_php);
                });

                $('.cancel').click(function(e) {
                    e.preventDefault();
                    reset();
                    closeModal();
                });

                function reset() {
                    $('#formJenisPHP')[0].reset();
                    $('.err').empty();
                }
            });
        </script>
    @endpush
@endsection
