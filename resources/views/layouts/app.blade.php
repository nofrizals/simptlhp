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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_info {
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        /* Samakan font dengan TailAdmin */
        .dataTables_wrapper {
            font-family: inherit;
            color: inherit;
        }

        /* Table header */
        table.dataTable thead th {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            /* text-gray-700 */
        }

        /* Table body */
        table.dataTable tbody td {
            font-size: 14px;
            color: #1f2937;
            /* text-gray-800 */
        }

        /* Search input */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 14px;
        }

        /* Select show entries */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
            font-size: 14px;
        }

        /* Pagination button */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem;
            padding: 0.4rem 0.75rem;
            margin: 0 2px;
        }

        /* Active page */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #3b82f6 !important;
            color: white !important;
            border: none;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
        }

        .dataTables_wrapper .dataTables_filter {
            justify-content: flex-end;
        }

        .dataTables_wrapper .dataTables_length {
            justify-content: flex-start;
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
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

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
