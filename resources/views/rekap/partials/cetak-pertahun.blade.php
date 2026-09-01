@php
    $fmt = fn(float $v) => 'Rp' . number_format($v, 2, ',', '.');
@endphp

<div class="relative rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="p-6">
        <div id="printMe" class="overflow-auto pb-4 text-xs">
            <div class="mb-4 text-center">
                <h6 class="font-semibold text-gray-800 dark:text-white">REKAPITULASI TEMUAN HASIL PEMERIKSAAN INSPEKTORAT
                    KABUPATEN SIAK</h6>
                @if ($subJudul)
                    <h6 class="font-semibold text-gray-800 dark:text-white">{{ $subJudul }}</h6>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="tablexls min-w-full border border-gray-300 text-[10px] dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="3">NO.</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="3">TAHUN</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="2">JUMLAH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="14">TINDAK
                                LANJUT</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="3"
                                rowspan="2">KEWAJIBAN STOR PAJAK(PPN & PPh)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="3"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="3"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN DESA</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="3"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN BLUD</th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="2">TEMUAN</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="2">REKOMENDASI
                            </th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="7">ADM</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="7">KEUANGAN
                            </th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BD</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">JML</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BD</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">JML</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $index => $data)
                            <tr>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $index + 1 }}.</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['tahun'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['temuanCount'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['rekomendasiCount'] }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['admin']['ssr'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['adminRatios']['ssr'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['admin']['bsr'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['adminRatios']['bsr'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['admin']['bd'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['adminRatios']['bd'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['admin']['jumlah'] }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuangan']['ssr'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuanganRatios']['ssr'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuangan']['bsr'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuanganRatios']['bsr'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuangan']['bd'] }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuanganRatios']['bd'] }}%</td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $data['keuangan']['jumlah'] }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['bk'][1]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['setoran'][1]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['sisa'][1]) }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['bk'][2]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['setoran'][2]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['sisa'][2]) }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['bk'][3]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['setoran'][3]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['sisa'][3]) }}</td>

                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['bk'][4]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['setoran'][4]) }}</td>
                                <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($data['sisa'][4]) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="26"
                                    class="border border-gray-300 px-1 py-4 text-center italic text-gray-500 dark:border-gray-700">
                                    Tidak ada data untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse

                        @if ($rows->isNotEmpty())
                            @php $t = $totals; @endphp
                            <tr class="font-semibold">
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700"
                                    colspan="2">JUMLAH</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['temuan'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['rekomendasi'] }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['ssr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['adminRatios']['ssr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['bsr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['adminRatios']['bsr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['bd'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['adminRatios']['bd'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['jumlah'] }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['ssr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuanganRatios']['ssr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['bsr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuanganRatios']['bsr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['bd'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuanganRatios']['bd'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['jumlah'] }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][1]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][1]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][1]) }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][2]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][2]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][2]) }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][3]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][3]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][3]) }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][4]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][4]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][4]) }}</th>
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
        <button type="button" id="rekapPertahun-xlsx" data-id-jenis-php="{{ $filters['id_jenis_php'] }}"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">
            Export Excel
        </button>
        <button type="button" id="print"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5">
            Print
        </button>
    </div>
</div>
