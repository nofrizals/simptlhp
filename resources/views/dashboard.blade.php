@extends('layouts.app')
@section('title', 'Dashboard | SIMPTLHP')
@section('page-data', "'ecommerce'")
@section('content')
    <div class="flex min-h-[60vh] items-end justify-center p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        {{-- <div class="text-center">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
                Selamat Datang
            </h1>

            <p class="mt-1 text-gray-500 dark:text-gray-400">
                SISTEM INFORMASI MENAJEMEN TINDAK LANJUT HASIL PEMERIKSAAN INSPEKTORAT DAERAH KABUPATEN SIAK
            </p>
        </div> --}}



        <div
            class="mb-6 overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="relative px-6 py-8 sm:px-10 sm:py-10">

                {{-- Background decoration --}}
                <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-brand-500/10 blur-3xl">
                </div>
                <div class="pointer-events-none absolute -bottom-20 left-1/3 h-40 w-40 rounded-full bg-blue-500/10 blur-3xl">
                </div>

                <div class="relative flex flex-col items-center justify-between gap-8 md:flex-row">

                    {{-- Illustration --}}
                    <div class="welcome-illustration relative flex h-32 w-32 shrink-0 items-center justify-center">

                        {{-- Glow --}}
                        <div class="absolute inset-0 rounded-full bg-brand-500/10 blur-2xl"></div>

                        {{-- Floating circles --}}
                        <div class="welcome-dot welcome-dot-1 absolute left-1 top-4 h-2 w-2 rounded-full bg-brand-500"></div>
                        <div class="welcome-dot welcome-dot-2 absolute right-2 top-10 h-3 w-3 rounded-full bg-blue-500/70">
                        </div>
                        <div
                            class="welcome-dot welcome-dot-3 absolute bottom-5 left-5 h-2 w-2 rounded-full bg-purple-500/70">
                        </div>

                        {{-- Main icon --}}
                        <div
                            class="welcome-icon relative flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-brand-500 to-blue-600 shadow-lg shadow-brand-500/25">
                            <svg class="h-32 w-48" viewBox="0 0 300 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="mouseBody" x1="0" y1="0" x2="1"
                                        y2="1">
                                        <stop offset="0%" stop-color="#CBD5E1" />
                                        <stop offset="100%" stop-color="#64748B" />
                                    </linearGradient>

                                    <linearGradient id="uniform" x1="0" y1="0" x2="1"
                                        y2="1">
                                        <stop offset="0%" stop-color="#FB923C" />
                                        <stop offset="100%" stop-color="#EA580C" />
                                    </linearGradient>

                                    <filter id="shadow" x="-30%" y="-30%" width="160%" height="160%">
                                        <feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="#0F172A"
                                            flood-opacity="0.15" />
                                    </filter>
                                </defs>

                                <!-- Ground -->
                                <ellipse cx="150" cy="157" rx="125" ry="8" fill="#0F172A"
                                    opacity="0.07" />

                                <!-- ================================= -->
                                <!-- SPEED LINES -->
                                <!-- ================================= -->

                                <g opacity="0.5">
                                    <path d="M15 108H48" stroke="#94A3B8" stroke-width="3" stroke-linecap="round" />

                                    <path d="M22 120H55" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />

                                    <path d="M35 132H60" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                </g>

                                <!-- ================================= -->
                                <!-- MOUSE - FRONT / LEFT -->
                                <!-- ================================= -->

                                <g filter="url(#shadow)" style="transform-origin: 75px 105px">

                                    <!-- Tail -->
                                    <path d="M91 124
                   C108 136 119 132 119 120
                   C119 113 113 111 108 116" stroke="#9F6B6B" stroke-width="5" stroke-linecap="round" fill="none">
                                        <animate attributeName="d"
                                            values="
                    M91 124 C108 136 119 132 119 120 C119 113 113 111 108 116;
                    M91 124 C110 140 123 133 121 119 C120 112 114 111 108 116;
                    M91 124 C108 136 119 132 119 120 C119 113 113 111 108 116
                "
                                            dur="0.6s" repeatCount="indefinite" />
                                    </path>

                                    <!-- Body -->
                                    <ellipse cx="75" cy="111" rx="27" ry="30"
                                        fill="url(#mouseBody)" />

                                    <!-- Left Ear -->
                                    <circle cx="56" cy="79" r="15" fill="#A8B1C0" />

                                    <circle cx="56" cy="79" r="9" fill="#F3A6A6" />

                                    <!-- Right Ear -->
                                    <circle cx="94" cy="79" r="15" fill="#A8B1C0" />

                                    <circle cx="94" cy="79" r="9" fill="#F3A6A6" />

                                    <!-- Face -->
                                    <ellipse cx="75" cy="88" rx="25" ry="22" fill="#B8C0CC" />

                                    <!-- Eyes -->
                                    <circle cx="65" cy="85" r="5" fill="#0F172A" />

                                    <circle cx="85" cy="85" r="5" fill="#0F172A" />

                                    <!-- Eye highlights -->
                                    <circle cx="66.5" cy="83.5" r="1.7" fill="white" />

                                    <circle cx="86.5" cy="83.5" r="1.7" fill="white" />

                                    <!-- Nose -->
                                    <ellipse cx="75" cy="96" rx="6" ry="5"
                                        fill="#E58B8B" />

                                    <!-- Cute scared mouth -->
                                    <path d="M70 103
                   C73 100 77 100 80 103" stroke="#64748B" stroke-width="2.5" stroke-linecap="round" />

                                    <!-- Whiskers -->
                                    <path d="M61 96L43 91" stroke="#64748B" stroke-width="2" stroke-linecap="round" />

                                    <path d="M61 101L42 104" stroke="#64748B" stroke-width="2" stroke-linecap="round" />

                                    <path d="M89 96L107 91" stroke="#64748B" stroke-width="2" stroke-linecap="round" />

                                    <path d="M89 101L108 104" stroke="#64748B" stroke-width="2" stroke-linecap="round" />

                                    <!-- Suit -->
                                    <path d="M54 113
                   C59 106 66 103 75 103
                   C84 103 92 106 97 113
                   L94 141
                   H56
                   L53 113Z" fill="#1E293B" />

                                    <!-- Shirt -->
                                    <path d="M67 105L75 116L83 105L79 104H71L67 105Z" fill="white" />

                                    <!-- Tie -->
                                    <path d="M75 109
                   L69 117
                   L75 134
                   L81 117
                   L75 109Z" fill="#EF4444" />

                                    <!-- Arms running -->
                                    <path d="M57 115L43 128" stroke="#A8B1C0" stroke-width="9" stroke-linecap="round" />

                                    <path d="M93 115L106 126" stroke="#A8B1C0" stroke-width="9" stroke-linecap="round" />

                                    <!-- Legs -->
                                    <path d="M66 140L55 153" stroke="#737D8C" stroke-width="9" stroke-linecap="round" />

                                    <path d="M84 140L96 151" stroke="#737D8C" stroke-width="9" stroke-linecap="round" />

                                    <!-- Shoes -->
                                    <ellipse cx="52" cy="155" rx="12" ry="5"
                                        fill="#1E293B" />

                                    <ellipse cx="99" cy="153" rx="12" ry="5"
                                        fill="#1E293B" />

                                    <!-- Running bounce -->
                                    <animateTransform attributeName="transform" type="translate"
                                        values="0 0; 0 -5; 0 0; 0 -4; 0 0" dur="0.45s" repeatCount="indefinite" />
                                </g>

                                <!-- ================================= -->
                                <!-- EXTERMINATOR - BEHIND / RIGHT -->
                                <!-- ================================= -->

                                <g filter="url(#shadow)" style="transform-origin: 205px 105px">

                                    <!-- Body -->
                                    <path d="M190 91
                   C190 82 197 76 206 76
                   C215 76 222 82 222 91
                   V127
                   H190V91Z" fill="url(#uniform)" />

                                    <!-- Head -->
                                    <circle cx="206" cy="62" r="18" fill="#F4B183" />

                                    <!-- Hair -->
                                    <path d="M188 58
                   C189 46 197 41 206 41
                   C216 41 223 48 224 59
                   C218 54 212 53 206 54
                   C199 54 194 56 188 58Z" fill="#334155" />

                                    <!-- Cap -->
                                    <path d="M188 49
                   C194 39 218 38 224 49
                   L221 54
                   H191L188 49Z" fill="#166534" />

                                    <path d="M185 52H227" stroke="#14532D" stroke-width="6" stroke-linecap="round" />

                                    <!-- Eyes looking left -->
                                    <circle cx="199" cy="63" r="3" fill="#1E293B" />

                                    <circle cx="213" cy="63" r="3" fill="#1E293B" />

                                    <!-- Determined smile -->
                                    <path d="M199 71
                   C203 74 209 74 213 71" stroke="#7C2D12" stroke-width="2.5" stroke-linecap="round" />

                                    <!-- Left arm reaching toward mouse -->
                                    <path d="M194 95
                   C181 98 174 106 169 116" stroke="#F4B183" stroke-width="9" stroke-linecap="round" />

                                    <!-- Right arm -->
                                    <path d="M219 95
                   C226 101 228 108 229 116" stroke="#F4B183" stroke-width="9" stroke-linecap="round" />

                                    <!-- Broom handle -->
                                    <path d="M170 82L158 143" stroke="#92400E" stroke-width="5" stroke-linecap="round" />

                                    <!-- Broom head -->
                                    <path d="M151 138
                   C151 138 157 150 168 153
                   C172 154 174 151 172 147
                   L166 135Z" fill="#D97706" />

                                    <path d="M155 139L161 151" stroke="#FBBF24" stroke-width="2" />

                                    <path d="M160 137L166 151" stroke="#FBBF24" stroke-width="2" />

                                    <path d="M165 136L171 148" stroke="#FBBF24" stroke-width="2" />

                                    <!-- Legs running -->
                                    <path d="M198 126L186 148" stroke="#F4B183" stroke-width="9"
                                        stroke-linecap="round" />

                                    <path d="M213 126L225 147" stroke="#F4B183" stroke-width="9"
                                        stroke-linecap="round" />

                                    <!-- Shoes -->
                                    <ellipse cx="183" cy="151" rx="12" ry="5"
                                        fill="#1E293B" />

                                    <ellipse cx="228" cy="150" rx="12" ry="5"
                                        fill="#1E293B" />

                                    <!-- Running bounce -->
                                    <animateTransform attributeName="transform" type="translate"
                                        values="0 0; 0 -5; 0 0; 0 -4; 0 0" dur="0.48s" repeatCount="indefinite" />
                                </g>

                                <!-- ================================= -->
                                <!-- PANIC SYMBOL -->
                                <!-- ================================= -->

                                <g>
                                    <text x="102" y="52" font-family="Arial, sans-serif" font-size="22"
                                        font-weight="bold" fill="#EF4444">
                                        !
                                    </text>

                                    <animate attributeName="opacity" values="1;0.3;1" dur="0.7s"
                                        repeatCount="indefinite" />
                                </g>

                                <!-- ================================= -->
                                <!-- CHASE MOTION LINES -->
                                <!-- ================================= -->

                                <path d="M125 96H145" stroke="#94A3B8" stroke-width="3" stroke-linecap="round"
                                    opacity="0.6" />

                                <path d="M132 106H153" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"
                                    opacity="0.7" />
                            </svg>

                        </div>
                    </div>

                    {{-- Text --}}
                    <div class="welcome-content flex-1 text-center md:text-left">
                        <div
                            class="mb-2 inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                            <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-brand-500"></span>
                            Sistem Monitoring & Pelaporan
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white sm:text-3xl">
                            Selamat Datang di
                            <span class="text-brand-500">SIMPTLHP</span>
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400 sm:text-base">
                            Pantau perkembangan dan tindak lanjut laporan hasil pemeriksaan
                            melalui dashboard yang terintegrasi dan informatif.
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
