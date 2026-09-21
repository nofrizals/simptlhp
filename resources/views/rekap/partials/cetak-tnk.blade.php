@php
    $namaObrik = $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor;
    $waktuPelaksanaan = '';
    if ($kasus->spt_mulai) {
        $waktuPelaksanaan =
            \Carbon\Carbon::parse($kasus->spt_mulai)->translatedFormat('d M Y') .
            ' ~ ' .
            \Carbon\Carbon::parse($kasus->spt_selesai)->translatedFormat('d M Y');
    }
    $sisa1 = max($bk[1] - $setoran[1], 0);
    $sisa2 = max($bk[2] - $setoran[2], 0);
    $sisa3 = max($bk[3] - $setoran[3], 0);
    $sisa4 = max($bk[4] - $setoran[4], 0);

    $fmt = fn(float $v) => 'Rp' . number_format($v, 2, ',', '.');
@endphp

<div
    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-white/90 dark:bg-gray-900">
    <div class="p-6">
        <div id="printMe" class="overflow-auto pb-4 text-xs">
            <div class="mb-4 text-center">
                <h6 class="font-semibold text-gray-800 dark:text-white">REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN</h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">
                    {{ $kasus->jenis_php?->jenis_php }} INSPEKTORAT DAERAH KABUPATEN SIAK
                </h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">TAHUN PHP : {{ $kasus->tahun_pemeriksaan }}</h6>
            </div>

            <div class="overflow-x-auto">
                <table class="tablexls min-w-full border border-gray-300 text-[11px] dark:border-white/90">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="3">NO</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="3">NO. &amp;
                                TGL SURAT TUGAS</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="3">WAKTU
                                PELAKSANAAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="3">NOMOR LHP
                            </th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="3">OBJEK
                                PEMERIKSAAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                colspan="2">JUMLAH</th>
                            @if ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="5">TINDAK
                                    LANJUT</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="3" rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                            @else
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="10">TINDAK
                                    LANJUT</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="3" rowspan="2">KEWAJIBAN STOR PAJAK(PPN &amp; PPh)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="3" rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="3" rowspan="2">KEWAJIBAN SETOR KERUGIAN DESA</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="3" rowspan="2">KEWAJIBAN SETOR KERUGIAN BLUD</th>
                            @endif
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="2">TEMUAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                rowspan="2">REKOMENDASI
                            </th>
                            @unless ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                    colspan="5">
                                    ADMINISTRASI</th>
                            @endunless
                            <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90"
                                colspan="5">KEUANGAN
                            </th>
                        </tr>
                        <tr>
                            @if ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">SSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BD
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">JLH
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">%
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    SISA (Rp)</th>
                            @else
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">SSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BD
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">JLH
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">%
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">SSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BSR
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">BD
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">JLH
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">%
                                </th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                    SISA (Rp)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- readTnk() CI = query agregat 1 baris untuk kasus ini, jadi baris data & baris
                             JUMLAH menampilkan angka yang identik. Dipertahankan supaya sama dengan output asli. --}}
                        <tr>
                            <td
                                class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                1.</td>
                            <td class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                {{ $kasus->spt }}</td>
                            <td class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                {{ $waktuPelaksanaan }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                {{ $kasus->nomor_lhp }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1 dark:border-white/90 dark:text-white/90">
                                {{ $namaObrik }}</td>
                            <td
                                class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                {{ $temuanCount }}</td>
                            <td
                                class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                {{ $rekomendasiCount }}</td>

                            @if ($isTgr)
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuanganRatio }}%</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa2) }}</td>
                            @else
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $adminRatio }}%</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuanganRatio }}%</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[1]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[1]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa1) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa2) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[3]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[3]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa3) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[4]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[4]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa4) }}</td>
                            @endif
                        </tr>

                        <tr class="font-semibold">
                            <th class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90"
                                colspan="5">JUMLAH</th>
                            <td
                                class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                {{ $temuanCount }}</td>
                            <td
                                class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                {{ $rekomendasiCount }}</td>

                            @if ($isTgr)
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuanganRatio }}%</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa2) }}</td>
                            @else
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $admin['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $adminRatio }}%</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['ssr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bsr'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['bd'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuangan['jumlah'] }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-center dark:border-white/90 dark:text-white/90">
                                    {{ $keuanganRatio }}%</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[1]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[1]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa1) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[2]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa2) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[3]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[3]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa3) }}</td>

                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($bk[4]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($setoran[4]) }}</td>
                                <td
                                    class="border border-gray-300 px-2 py-1 text-right dark:border-white/90 dark:text-white/90">
                                    {{ $fmt($sisa4) }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>

            <br><br>

            <div class="flex flex-col gap-6 text-xs md:flex-row md:justify-between">
                <div>
                    <div class="mb-1 font-medium dark:text-white/90">Keterangan:</div>
                    <table class="border-0">
                        <tr>
                            <td class="pr-2">SSR</td>
                            <td class="dark:text-white/90">: Sudah Sesuai Rekomendasi (Selesai)</td>
                        </tr>
                        <tr>
                            <td class="pr-2">BSR</td>
                            <td class="dark:text-white/90">: Belum Sesuai Rekomendasi (Perlu Dilengkapi)</td>
                        </tr>
                        <tr>
                            <td class="pr-2">BD</td>
                            <td class="dark:text-white/90">: Belum ditindaklanjuti</td>
                        </tr>
                    </table>
                </div>
                <div class="dark:text-white/90">
                    <div>SIAK SRI INDRAPURA, {{ now()->translatedFormat('d F Y') }}</div>
                    <div>INSPEKTUR KABUPATEN SIAK</div>
                    <div class="py-8"></div>
                    <div><u>{{ $ttd->nama_pegawai ?? '-' }}</u></div>
                    <div>NIP {{ $ttd->id_pegawai ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-6 py-4 dark:border-gray-800">
        <button type="button" id="rekaptnk-xlsx" data-id="{{ $kasus->id_kasus }}"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 dark:text-white/90">
            Export Excel
        </button>
        <button type="button" id="print"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-white/90 dark:bg-gray-800 dark:text-white/90 dark:hover:bg-white/5">
            Print
        </button>
    </div>
</div>
