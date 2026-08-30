<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-10 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="flex items-center gap-2 pt-8 sidebar-header pb-7">
        <a href="{{ url('dashboard') }}">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
                <img class="hidden dark:block" src="{{ asset('images/logo/logo-dark.svg') }}" alt="Logo" />
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('images/logo/logo-icon.svg') }}" alt="Logo" />
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <!-- Sidebar Menu -->
        <nav x-data="{ selected: $persist('Dashboard') }">
            <!-- Menu -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        MENU
                    </span>

                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>

                <ul class="mb-6 flex flex-col gap-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ url('dashboard') }}"
                            class="menu-item group {{ request()->is('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                                    fill="" />
                            </svg>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <!-- Admin -->
                    <li>
                        <a href="{{ url('admin') }}"
                            class="menu-item group {{ request()->is('admin') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('admin') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                                    fill="" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Admin
                            </span>
                        </a>
                    </li>
                    <!-- Master -->
                    <li>
                        <a href="#" @click.prevent="selected = (selected === 'Masters' ? '' : 'Masters')"
                            class="menu-item group {{ request()->is('jenis-php', 'nilai-kerugian', 'status-tl', 'obrik', 'obrik-turunan') ? 'menu-item-active' : 'menu-item-inactive' }}">

                            <svg class="{{ request()->is('jenis-php', 'nilai-kerugian', 'status-tl', 'obrik', 'obrik-turunan') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Data Master
                            </span>

                            <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Masters') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                    sidebarToggle ? 'lg:hidden' : ''
                                ]"
                                width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Masters') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">

                                <li>
                                    <a href="{{ url('jenis-php') }}"
                                        class="menu-dropdown-item group {{ request()->is('jenis-php') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Jenis PHP
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('nilai-kerugian') }}"
                                        class="menu-dropdown-item group {{ request()->is('nilai-kerugian') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Nilai Kerugian
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('status-tl') }}"
                                        class="menu-dropdown-item group {{ request()->is('status-tl') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Status Tindak Lanjut
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('obrik') }}"
                                        class="menu-dropdown-item group {{ request()->is('obrik') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Obrik
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('obrik-turunan') }}"
                                        class="menu-dropdown-item group {{ request()->is('obrik-turunan') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Obrik Turunan
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <!-- Manajemen Tim -->
                    <li>
                        <a href="#"
                            @click.prevent="selected = (selected === 'Manajemen-tim' ? '':'Manajemen-tim')"
                            class="menu-item group {{ request()->is('daftar-tim', 'obrik-tim') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('daftar-tim', 'obrik-tim') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5 11C16.8807 11 18 9.88071 18 8.5C18 7.11929 16.8807 6 15.5 6C14.1193 6 13 7.11929 13 8.5C13 9.88071 14.1193 11 15.5 11Z
                                    M8.5 11C9.88071 11 11 9.88071 11 8.5C11 7.11929 9.88071 6 8.5 6C7.11929 6 6 7.11929 6 8.5C6 9.88071 7.11929 11 8.5 11Z
                                    M3 18C3 15.7909 4.79086 14 7 14H10C12.2091 14 14 15.7909 14 18
                                    M10 18C10 15.7909 11.7909 14 14 14H17C19.2091 14 21 15.7909 21 18" stroke="#737070"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Manajemen Tim
                            </span>
                            <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Manajemen-tim') ? 'menu-item-arrow-active' :
                                    'menu-item-arrow-inactive',
                                    sidebarToggle ? 'lg:hidden' : ''
                                ]"
                                width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Manajemen-tim') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                <li>
                                    <a href="{{ url('daftar-tim') }}"
                                        class="menu-dropdown-item group {{ request()->is('daftar-tim') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Daftar Tim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('obrik-tim') }}"
                                        class="menu-dropdown-item group {{ request()->is('obrik-tim') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Obrik Ditangani
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Manajemen Kasus -->
                    <li>
                        <a href="#"
                            @click.prevent="selected = (selected === 'Manajemen-kasus' ? '':'Manajemen-kasus')"
                            class="menu-item group {{ request()->is('daftar-kasus', 'verifikasi-ssr*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('daftar-kasus', 'verifikasi-ssr*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 3H7C6.44772 3 6 3.44772 6 4V20C6 20.5523 6.44772 21 7 21H17C17.5523 21 18 20.5523 18 20V7L14 3Z"
                                    fill="none" stroke="#737070" stroke-width="1.5" stroke-linejoin="round" />

                                <path d="M14 3V7H18" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linejoin="round" />

                                <circle cx="10.5" cy="12.5" r="2.5" fill="none" stroke="#737070"
                                    stroke-width="1.5" />

                                <path d="M12.5 14.5L14.5 16.5" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Manajemen Kasus
                            </span>
                            <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Manajemen-kasus') ? 'menu-item-arrow-active' :
                                    'menu-item-arrow-inactive',
                                    sidebarToggle ? 'lg:hidden' : ''
                                ]"
                                width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Manajemen-kasus') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                <li>
                                    <a href="{{ url('daftar-kasus') }}"
                                        class="menu-dropdown-item group {{ request()->is('daftar-kasus') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        Daftar Kasus
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('verifikasi-ssr') }}"
                                        class="menu-dropdown-item group flex items-center gap-2 {{ request()->is('verifikasi-ssr*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        <span>Verifikasi SSR</span>
                                        @if ($countApprove > 0)
                                            <span
                                                class="rounded-full bg-blue-600 px-2 py-0.5 text-xs font-medium text-white">
                                                {{ $countApprove }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                    <!-- Kasus -->
                    {{-- <li>
                        <a href="{{ url('kasus') }}"
                            class="menu-item group {{ request()->is('kasus') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('kasus') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 3H7C6.44772 3 6 3.44772 6 4V20C6 20.5523 6.44772 21 7 21H17C17.5523 21 18 20.5523 18 20V7L14 3Z"
                                    fill="none" stroke="#737070" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M14 3V7H18" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linejoin="round" />
                                <path d="M9 11H15" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <path d="M9 14H15" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <path d="M9 17H13" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Kasus
                            </span>
                        </a>
                    </li> --}}

                    <li>
                        <a href="#"
                            @click.prevent="selected = (selected === 'Rekap-laporan' ? '':'Rekap-laporan')"
                            class="menu-item group {{ request()->is('rekap/php-tnk', 'rekap/apbkam') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('rekap/php-tnk', 'rekap/apbkam') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 3H7C6.44772 3 6 3.44772 6 4V20C6 20.5523 6.44772 21 7 21H17C17.5523 21 18 20.5523 18 20V7L14 3Z"
                                    fill="none" stroke="#737070" stroke-width="1.5" stroke-linejoin="round" />

                                <path d="M14 3V7H18" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linejoin="round" />

                                <circle cx="10.5" cy="12.5" r="2.5" fill="none" stroke="#737070"
                                    stroke-width="1.5" />

                                <path d="M12.5 14.5L14.5 16.5" fill="none" stroke="#737070" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Rekap Laporan
                            </span>
                            <svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                                :class="[(selected === 'Rekap-laporan') ? 'menu-item-arrow-active' :
                                    'menu-item-arrow-inactive',
                                    sidebarToggle ? 'lg:hidden' : ''
                                ]"
                                width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="overflow-hidden transform translate"
                            :class="(selected === 'Rekap-laporan') ? 'block' : 'hidden'">
                            <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                <li>
                                    <a href="{{ url('rekap/php-tnk') }}"
                                        class="menu-dropdown-item group {{ request()->is('rekap/php-tnk') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        PHP / TNK
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('rekap/apbkam') }}"
                                        class="menu-dropdown-item group flex items-center gap-2 {{ request()->is('rekap/apbkam') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                        <span>APBKAM</span>
                                        @if ($countApprove > 0)
                                            <span
                                                class="rounded-full bg-blue-600 px-2 py-0.5 text-xs font-medium text-white">
                                                {{ $countApprove }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>


                </ul>
            </div>
            <!-- Lainnya -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        Lainnya
                    </span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="mx-auto fill-current menu-group-icon" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>

                <ul class="flex flex-col gap-4 mb-6">
                    <!-- Peraturan -->
                    <li>
                        <a href="{{ url('peraturan') }}"
                            class="menu-item group {{ request()->is('peraturan') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ request()->is('peraturan') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <path d="M6 6H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <!-- Left string -->
                                <path d="M8 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <!-- Right string -->
                                <path d="M16 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <!-- Left scale -->
                                <path d="M6.5 10H9.5L8 13H6L6.5 10Z" stroke="currentColor" stroke-width="1.5"
                                    stroke-linejoin="round" />

                                <!-- Right scale -->
                                <path d="M14.5 10H17.5L18 13H16L14.5 10Z" stroke="currentColor" stroke-width="1.5"
                                    stroke-linejoin="round" />

                                <!-- Base -->
                                <path d="M10 18H14" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />

                                <path d="M12 6V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Peraturan
                            </span>
                        </a>
                    </li>
                    <!-- Kontak -->
                    <li>
                        <a href="{{ url('kontak') }}"
                            class="menu-item group {{ request()->is('kontak') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">

                                <!-- User kiri -->
                                <circle cx="8" cy="9" r="2.5" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path d="M4.5 18C4.5 15.5 6.2 14 8 14C9.8 14 11.5 15.5 11.5 18" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />

                                <!-- User kanan -->
                                <circle cx="16" cy="9" r="2.5" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path d="M12.5 18C12.5 15.5 14.2 14 16 14C17.8 14 19.5 15.5 19.5 18"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <!-- koneksi (representasi kontak) -->
                                <path d="M10.5 10.5L13.5 10.5" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Kontak
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Data Log -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        Data Log
                    </span>
                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="mx-auto fill-current menu-group-icon" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>
                <ul class="flex flex-col gap-4 mb-6">
                    <!-- Riwayat Login -->
                    <li>
                        <a href="{{ url('access-log') }}"
                            class="menu-item group {{ request()->is('access-log') ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">

                                <!-- User -->
                                <circle cx="12" cy="9" r="3" stroke="currentColor"
                                    stroke-width="1.5" />

                                <path d="M7 18C7 15.5 9.5 14 12 14C14.5 14 17 15.5 17 18" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />

                                <!-- Clock -->
                                <circle cx="18" cy="18" r="3" stroke="currentColor"
                                    stroke-width="1.5" />

                                <path d="M18 17V18.5L19 19" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />

                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Riwayat Login
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>
