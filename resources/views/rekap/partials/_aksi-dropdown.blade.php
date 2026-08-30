{{-- Alpine.js meng-observe DOM baru secara otomatis (MutationObserver bawaan Alpine),
     jadi x-data di sini tetap ter-hydrate walau baris ini di-render ulang oleh DataTables. --}}
<div class="relative inline-block text-left" x-data="{ open: false }">
    <button type="button" @click="open = !open" @click.outside="open = false"
        class="inline-flex items-center gap-1 rounded-lg bg-brand-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-600">
        Cetak
        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" x-transition
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-lg border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-800 dark:bg-gray-900"
        style="display: none;">
        {{-- Endpoint cetak-php / cetak-tnk menyusul di Bagian B --}}
        <a href="javascript:void(0)" data-id="{{ $kasus->id_kasus }}"
            class="btn-cetak-php block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5">
            PHP
        </a>
        <a href="javascript:void(0)" data-id="{{ $kasus->id_kasus }}"
            data-tahun-pemeriksaan="{{ $kasus->tahun_pemeriksaan }}"
            class="btn-cetak-tnk block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5">
            Rekap temuan/nilai kerugian
        </a>
    </div>
</div>
