@php
    $fmt = fn(float $v) => 'Rp' . number_format($v, 2, ',', '.');
    $colspanKosong = $isTgr ? 16 : 30;
@endphp

<div
    class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="p-6">
        <div id="printMe" class="overflow-auto pb-4 text-xs">
            <div class="mb-4 text-center">
                <h6 class="font-semibold text-gray-800 dark:text-white">REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN</h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">{{ $jenisPhpLabel }} INSPEKTORAT DAERAH KABUPATEN
                    SIAK</h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">{{ $namaInstansiLabel }}</h6>
            </div>

            <div class="overflow-x-auto">
                <table class="tablexls min-w-full border border-gray-300 text-[11px] dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="3">NO</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="3">NO. & TGL
                                SURAT TUGAS</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="3">WAKTU
                                PELAKSANAAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="3">NOMOR LHP
                            </th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="3">TAHUN
                                PEMERIKSAAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="2">JUMLAH</th>
                            @if ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="5">TINDAK
                                    LANJUT</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="3"
                                    rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                            @else
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="10">TINDAK
                                    LANJUT</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="3"
                                    rowspan="2">KEWAJIBAN STOR PAJAK(PPN & PPh)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="3"
                                    rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="3"
                                    rowspan="2">KEWAJIBAN SETOR KERUGIAN DESA</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="3"
                                    rowspan="2">KEWAJIBAN SETOR KERUGIAN BLUD</th>
                            @endif
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="2">TEMUAN</th>
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" rowspan="2">REKOMENDASI
                            </th>
                            @unless ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="5">
                                    ADMINISTRASI</th>
                            @endunless
                            <th class="border border-gray-300 px-2 py-1 dark:border-gray-700" colspan="5">KEUANGAN
                            </th>
                        </tr>
                        <tr>
                            @if ($isTgr)
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BD</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">JLH</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">%</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SISA (Rp)</th>
                            @else
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BD</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">JLH</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">%</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BSR</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">BD</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">JLH</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">%</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SISA (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">NILAI (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                                <th class="border border-gray-300 px-2 py-1 dark:border-gray-700">SISA (Rp)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $data)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $data['no'] }}.</td>
                                <td class="border border-gray-300 px-2 py-1 dark:border-gray-700">{{ $data['spt'] }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1 dark:border-gray-700">
                                    {{ $data['waktuPelaksanaan'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 dark:border-gray-700">
                                    {{ $data['nomorLhp'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $data['tahun'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $data['temuanCount'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $data['rekomendasiCount'] }}</td>

                                @if ($isTgr)
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuanganRatio'] }}%</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][2]) }}</td>
                                @else
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['adminRatio'] }}%</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuanganRatio'] }}%</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][1]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][1]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][1]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][2]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][3]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][3]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][3]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][4]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][4]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][4]) }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspanKosong }}"
                                    class="border border-gray-300 px-2 py-4 text-center italic text-gray-500 dark:border-gray-700">
                                    Tidak ada data untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse

                        @if ($rows->isNotEmpty())
                            <tr class="font-semibold">
                                <th class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700"
                                    colspan="6">JUMLAH</th>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $totals['temuan'] }}</td>
                                <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                    {{ $totals['rekomendasi'] }}</td>

                                @if ($isTgr)
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuanganRatio'] }}%</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['bk'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['setoran'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['sisa'][2]) }}</td>
                                @else
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['admin']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['admin']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['admin']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['admin']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['adminRatio'] }}%</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['bd'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuangan']['jumlah'] }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-center dark:border-gray-700">
                                        {{ $totals['keuanganRatio'] }}%</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['bk'][1]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['setoran'][1]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['sisa'][1]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['bk'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['setoran'][2]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['sisa'][2]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['bk'][3]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['setoran'][3]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['sisa'][3]) }}</td>

                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['bk'][4]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['setoran'][4]) }}</td>
                                    <td class="border border-gray-300 px-2 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($totals['sisa'][4]) }}</td>
                                @endif
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <br><br>

            <div class="flex flex-col gap-6 text-xs md:flex-row md:justify-between">
                <div>
                    <div class="mb-1 font-medium">Keterangan:</div>
                    <table class="border-0">
                        <tr>
                            <td class="pr-2">SSR</td>
                            <td>: Sudah Sesuai Rekomendasi (Selesai)</td>
                        </tr>
                        <tr>
                            <td class="pr-2">BSR</td>
                            <td>: Belum Sesuai Rekomendasi (Perlu Dilengkapi)</td>
                        </tr>
                        <tr>
                            <td class="pr-2">BD</td>
                            <td>: Belum ditindaklanjuti</td>
                        </tr>
                    </table>
                </div>
                <div>
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
        <button type="button" id="rekaptnkkolektif-xlsx" data-id-jenis-php="{{ $filters['id_jenis_php'] }}"
            data-tahun-pemeriksaan="{{ $filters['tahun_pemeriksaan'] }}"
            data-kode-unor="{{ $filters['kode_unor'] }}"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
            Export Excel
        </button>
        <button type="button" id="print"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
            Print
        </button>
    </div>
</div>
