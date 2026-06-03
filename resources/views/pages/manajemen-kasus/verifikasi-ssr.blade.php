@extends('layouts.app')

@section('title', 'Approval Tindak Lanjut SSR | SIMPTLHP')
@section('page-data', "'verifikasi-ssr'")

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: `Approval Tindak Lanjut SSR` }">
            @include('partials.breadcrumb')
        </div>
        <div class="space-y-5 sm:space-y-6">
            <div class="relative border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
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
                <table id="verifikasiSsrTable" class="min-w-full divide-y divide-gray-200 display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Tindak Lanjut</th>
                            <th>Tindak Lanjut</th>
                            <th>File</th>
                            <th>Rincian Temuan Keuangan Pajak</th>
                            <th>Rincian Temuan Keuangan Daerah</th>
                            <th>Rincian Temuan Keuangan Desa</th>
                            <th>Rincian Temuan Keuangan Blud</th>
                            <th>Status Tindak Lanjut</th>
                            <th>Keterangan</th>
                            <th>Log</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                var table = $('#verifikasiSsrTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    language: {
                        emptyTable: `
                            <div class="flex flex-col items-center justify-center py-5">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data
                                </p>
                            </div>
                        `,
                        zeroRecords: `
                            <div class="flex flex-col items-center justify-center py-5">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Data tidak ditemukan
                                </p>
                            </div>
                        `,
                        search: "",
                        searchPlaceholder: "Cari data..."
                    },
                    ajax: {
                        type: 'POST',
                        url: "{{ url('ajax-data-verifikasi-ssr') }}",
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
                            data: 'id_jenis_php',
                            name: 'id_jenis_php',
                            className: 'text-center'
                        },
                        {
                            data: 'tahun_pemeriksaan',
                            name: 'tahun_pemeriksaan',
                            className: 'text-center'
                        },
                        {
                            data: 'spt',
                            name: 'spt',
                            className: 'text-center'
                        },
                        {
                            data: 'nomor_lhp',
                            name: 'nomor_lhp',
                            className: 'text-center'
                        },
                        {
                            data: 'tanggal_lhp',
                            name: 'tanggal_lhp',
                            className: 'text-center'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
                            className: 'text-center'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
                            className: 'text-center'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
                            className: 'text-center'
                        },
                        {
                            data: 'kode_unor',
                            name: 'kode_unor',
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

                function reset() {
                    $('#id').val('');
                    $('#formVerifikasiSsr')[0].reset();
                    $('.err').empty();
                }
            });
        </script>
    @endpush
@endsection
