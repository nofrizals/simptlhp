<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'SIMPTLHP')
    </title>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* === TailAdmin Pill Pagination === */
        .dataTables_paginate {
            display: flex !important;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* semua tombol */
        .dataTables_paginate .paginate_button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;

            min-width: 38px;
            height: 38px;

            padding: 0 12px !important;

            border-radius: 9999px !important;
            /* pill shape */
            border: 1px solid #E5E7EB !important;

            background: #fff !important;
            color: #374151 !important;

            font-size: 14px;
            font-weight: 500;

            transition: all .2s ease;
            cursor: pointer;
        }

        /* hover */
        .dataTables_paginate .paginate_button:hover {
            background: #F3F4F6 !important;
            border-color: #D1D5DB !important;
        }

        /* active page (PILL BLUE) */
        .dataTables_paginate .paginate_button.current {
            background: #465FFF !important;
            border-color: #465FFF !important;
            color: #fff !important;
        }

        /* disabled */
        .dataTables_paginate .paginate_button.disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        /* prev & next lebih clean */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            font-weight: 600;
        }

        #userTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        #userTable thead th {
            background: #F9FAFB;
            color: #6B7280;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 18px 24px;
            border-bottom: 1px solid #E5E7EB;
        }

        .dark #userTable thead th {
            background: #111827;
            color: #9CA3AF;
        }

        #userTable tbody td {
            padding: 16px 24px;
            color: #374151;
        }

        #userTable tbody tr {
            transition: all .15s ease;
        }

        .dark #userTable tbody td {
            border-color: #1F2937;
        }

        #userTable tbody tr:hover {
            background: #F9FAFB;
        }

        .dark #userTable tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Select2 Tailwind Style */
        .select2-container--default .select2-selection--single {
            height: 44px;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 6px 10px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1f2937;
            font-size: 14px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 10px;
        }

        .select2-dropdown {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .select2-search__field {
            border-radius: 0.375rem;
            padding: 6px;
        }

        #jenisPhpTable thead th {
            text-align: center !important;
        }

        #nilaiKerugianTable thead th {
            text-align: center !important;
        }

        #statusTlTable thead th {
            text-align: center !important;
        }

        #timTable thead th {
            text-align: center !important;
        }

        #kasusTable thead th {
            text-align: center !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body x-data="{ page: @yield('page-data'), loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">

    @include('partials.preloader')
    <div class="flex h-screen overflow-hidden">
        @include('partials.sidebar')

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            @include('partials.overlay')
            @include('partials.header')
            <div id="alert-container" class="mb-4"></div>
            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function notif(type, message) {

            let alertHtml = '';

            if (type === 'success') {
                alertHtml = `
        <div class="rounded-xl border border-success-500 bg-success-50 p-4 mb-4">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-success-500">✔</div>
                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800">
                        Success
                    </h4>
                    <p class="text-sm text-gray-500">${message}</p>
                </div>
            </div>
        </div>`;
            }

            if (type === 'error') {
                alertHtml = `
        <div class="rounded-xl border border-red-500 bg-red-50 p-4 mb-4">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-red-500">✖</div>
                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800">
                        Error
                    </h4>
                    <p class="text-sm text-gray-500">${message}</p>
                </div>
            </div>
        </div>`;
            }

            $('#alert-container').html(alertHtml);

            // auto hide setelah 5 detik
            setTimeout(function() {
                $('#alert-container').fadeOut();
            }, 5000);
        }
    </script>
    @stack('scripts')
</body>

</html>
