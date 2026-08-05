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

        .dt-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .dt-table thead th {
            background: #F9FAFB;
            color: #6B7280;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 18px 24px;
            border-bottom: 1px solid #E5E7EB;
        }

        .dark .dt-table thead th {
            background: #111827;
            color: #9CA3AF;
        }

        .dt-table tbody td {
            padding: 16px 24px;
            color: #374151;
        }

        .dt-table tbody tr {
            transition: all .15s ease;
        }

        .dark .dt-table tbody td {
            border-color: #1F2937;
        }

        .dt-table tbody tr:hover {
            background: #F9FAFB;
        }

        .dark .dt-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Container */
        .select2-container {
            width: 100% !important;
        }

        /* Selection */
        .select2-container--default .select2-selection--single {
            height: 44px;
            border: 1px solid #d1d5db;
            border-radius: .5rem;
            background-color: transparent;
            display: flex;
            align-items: center;
            /* padding: 0;
            transition: all .2s ease; */
            box-shadow: 0 1px 2px rgba(16, 24, 40, .05);
        }

        /* Hover */
        .select2-container--default .select2-selection--single:hover {
            border-color: #9ca3af;
        }

        /* Focus */
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #465fff;
            box-shadow: 0 0 0 3px rgba(70, 95, 255, .1);
        }

        /* Text */
        .select2-container--default .select2-selection__rendered {
            color: #1f2937;
            font-size: 14px;
            line-height: 44px;
            padding-left: 14px !important;
            padding-right: 40px !important;
        }

        /* Placeholder */
        .select2-container--default .select2-selection__placeholder {
            color: #9ca3af;
        }

        /* Arrow */
        .select2-container--default .select2-selection__arrow b {
            margin-top: 10px !important;
            top: 50% !important;
            transform: translateY(-50%);
        }

        .select2-container,
        .select2-dropdown {
            font-family: inherit;
        }

        /* Dropdown */
        .select2-dropdown {
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            overflow: hidden;
            box-shadow: 0 10px 15px rgba(0, 0, 0, .08);
        }

        /* Search */
        .select2-search--dropdown {
            padding: 10px;
        }

        .select2-search__field {
            height: 38px;
            border: 1px solid #d1d5db !important;
            border-radius: .5rem !important;
            padding: 0 10px !important;
            outline: none;
        }

        .select2-search__field:focus {
            border-color: #465fff !important;
            box-shadow: 0 0 0 3px rgba(70, 95, 255, .1);
        }

        /* Result */
        .select2-results__option {
            padding: 10px 14px;
            font-size: 14px;
        }

        /* Hover Result */
        .select2-results__option--highlighted {
            background: #465fff !important;
        }

        /* Selected */
        .select2-results__option--selected {
            background: #eef2ff;
            color: #465fff;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #f9fafb;
            cursor: not-allowed;
            opacity: .7;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #98a2b3;
            font-size: 18px;
            margin: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 25px !important;
            padding-right: 40px !important;
            line-height: 42px !important;
            color: #1f2937;
            font-size: 14px;
        }

        .dark .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #111827;
        }

        .dark .select2-container--default .select2-selection--single .select2-selection__clear {
            color: #d1d5db;
        }

        .dark .select2-container--default .select2-selection--single {
            background-color: #111827;
            border-color: #374151;
        }

        .dark .select2-container--default .select2-selection__rendered {
            color: #fff;
        }

        .dark .select2-dropdown {
            background: #101828;
            border-color: #344054;
        }

        .dark .select2-results__option {
            color: #fff;
        }

        .dark .select2-search__field {
            background: #101828;
            color: #fff;
            border-color: #344054 !important;
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
