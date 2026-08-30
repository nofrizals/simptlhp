<div
    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="p-6">
        <div id="printMe" class="overflow-auto pb-4">
            <div class="mb-4 text-center">
                <h6 class="font-semibold text-gray-800 dark:text-white">
                    MATRIK TINDAK LANJUT HASIL PEMERIKSAAN INSPEKTORAT DAERAH KABUPATEN SIAK
                </h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">
                    PADA {{ strtoupper($kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor) }}
                </h6>
            </div>

            <table class="tablexls w-3/4 text-xs text-gray-700 dark:text-gray-300" border="0">
                <tr>
                    <th class="text-left align-top">NO. &amp; TGL SURAT TUGAS</th>
                    <td class="text-left align-top" width="70%">
                        <span class="mx-2">:</span> {{ strtoupper((string) $kasus->spt) }}
                    </td>
                </tr>
                @php
                    $waktuPemeriksaan = '';
                    if ($kasus->spt_mulai) {
                        $waktuPemeriksaan =
                            \Carbon\Carbon::parse($kasus->spt_mulai)->translatedFormat('d M Y') .
                            ' s/d ' .
                            \Carbon\Carbon::parse($kasus->spt_selesai)->translatedFormat('d M Y');
                    }
                @endphp
                <tr>
                    <th class="text-left align-top">WAKTU PEMERIKSAAN</th>
                    <td class="text-left align-top"><span class="mx-2">:</span> {{ strtoupper($waktuPemeriksaan) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left align-top">NOMOR LHP</th>
                    <td class="text-left align-top"><span class="mx-2">:</span>
                        {{ strtoupper((string) $kasus->nomor_lhp) }}</td>
                </tr>
                <tr>
                    <th class="text-left align-top">TANGGAL LHP</th>
                    <td class="text-left align-top">
                        <span class="mx-2">:</span>
                        {{ $kasus->tanggal_lhp ? strtoupper(\Carbon\Carbon::parse($kasus->tanggal_lhp)->translatedFormat('d F Y')) : '' }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left align-top">NAMA OBRIK</th>
                    <td class="text-left align-top">
                        <span class="mx-2">:</span>
                        {{ strtoupper($kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left align-top">KETUA TIM</th>
                    <td class="text-left align-top">
                        <span class="mx-2">:</span>
                        {{-- Fallback tampilkan NIP mentah kalau resolusi nama tidak ditemukan --}}
                        {{ $ketuaTim ?? $kasus->nip_ketua }}
                    </td>
                </tr>
            </table>

            <br>

            <div class="overflow-x-auto">
                <table class="tablexls min-w-full border border-gray-300 text-xs dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700">TEMUAN</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="100px">NILAI KERUGIAN</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700">PENYEBAB</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700">REKOMENDASI
                            </th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="350px">TINDAK LANJUT</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="100px">TEMUAN KEUANGAN</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="100px">STOR</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="100px">SISA SETOR</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700"
                                width="10px">STATUS</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700">KETERANGAN
                            </th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700">TGL TINDAK
                                LANJUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['temuan'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {!! $row['nilai_kerugian'] !!}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['penyebab'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['rekomendasi'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['tindak_lanjut'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top text-right dark:border-gray-700">
                                    {{ $row['rincian'] > 0 ? 'Rp' . number_format($row['rincian'], 2, ',', '.') : '-' }}
                                </td>
                                <td class="border border-gray-300 px-2 py-2 align-top text-right dark:border-gray-700">
                                    {{ $row['setor'] > 0 ? 'Rp' . number_format($row['setor'], 2, ',', '.') : '-' }}
                                </td>
                                <td class="border border-gray-300 px-2 py-2 align-top text-right dark:border-gray-700">
                                    {{ $row['sisa'] > 0 ? 'Rp' . number_format($row['sisa'], 2, ',', '.') : '-' }}
                                </td>
                                <td class="border border-gray-300 px-2 py-2 align-top text-center dark:border-gray-700">
                                    {{ $row['status_tl'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['keterangan'] }}</td>
                                <td class="border border-gray-300 px-2 py-2 align-top dark:border-gray-700">
                                    {{ $row['tgl_tindak_lanjut'] ? \Carbon\Carbon::parse($row['tgl_tindak_lanjut'])->translatedFormat('d F Y') : '-' }}
                                    <br>
                                    Petugas entry : {{ $row['created_by_nama'] ?? '-' }}
                                    <br><br>
                                    @if ($row['edited_by_nama'])
                                        Telah diedit oleh {{ $row['edited_by_nama'] }}
                                        Pada Tanggal
                                        {{ \Carbon\Carbon::parse($row['edited_at'])->translatedFormat('d F Y') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11"
                                    class="border border-gray-300 px-2 py-4 text-center dark:border-gray-700">
                                    Tidak ada data temuan.
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-semibold">
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 text-right dark:border-gray-700">
                                Rp{{ number_format($totals['rincian'], 2, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 px-2 py-2 text-right dark:border-gray-700">
                                Rp{{ number_format($totals['setor'], 2, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 px-2 py-2 text-right dark:border-gray-700">
                                Rp{{ number_format($totals['sisa'], 2, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-700"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br><br>

            <table class="tablexls w-full text-xs" border="0">
                <tr>
                    <td width="40%"></td>
                    <td width="35%" class="text-left">SIAK SRI INDRAPURA, {{ now()->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"></td>
                    <td class="text-left">INSPEKTUR KABUPATEN SIAK</td>
                </tr>
                <tr>
                    <td class="text-left">&nbsp;<br>&nbsp;<br>&nbsp;</td>
                    <td class="text-left">&nbsp;<br>&nbsp;<br>&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-left"></td>
                    <td class="text-left"><u>{{ $ttd->nama_pegawai ?? '-' }}</u></td>
                </tr>
                <tr>
                    <td class="text-left"></td>
                    <td class="text-left">NIP {{ $ttd->id_pegawai ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4 dark:border-gray-800">
        <div class="text-sm text-gray-500">
            @if (empty($rows))
                <em>Keterangan : Tindak lanjut tidak ditemukan.</em>
            @endif
        </div>
        <div class="flex items-center gap-2">
            {{-- Endpoint export Excel (rekapphp-xlsx) menyusul di Bagian C --}}
            <button type="button" id="rekapphp-xlsx" data-id="{{ $kasus->id_kasus }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
                Export Excel
            </button>
            <button type="button" id="print"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
                Print
            </button>
        </div>
    </div>
</div>
