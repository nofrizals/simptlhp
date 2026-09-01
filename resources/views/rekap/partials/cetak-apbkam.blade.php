@php
    $fmt = fn(float $v) => 'Rp' . number_format($v, 2, ',', '.');
    $judulTahun = $tahunPemeriksaan !== 'semua' ? ' TAHUN ' . $tahunPemeriksaan : '';
@endphp

<div class="relative rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="p-6">
        <div id="printMe" class="overflow-auto pb-4 text-xs max-h-[80vh]">
            <div class="mb-4 text-center">
                <h6 class="font-semibold text-gray-800 dark:text-white">TEMUAN HASIL PEMERIKSAAN APBKAM INSPEKTORAT
                    KABUPATEN SIAK</h6>
                <h6 class="font-semibold text-gray-800 dark:text-white">{{ $kecamatanLabel }}{{ $judulTahun }}</h6>
            </div>

            <div class="overflow-x-auto">
                <table class="tablexls min-w-full border border-gray-300 text-[10px] dark:border-gray-700">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="3"
                                colspan="2">NO</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="3">OBJEK
                                PEMERIKSAAN</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="2">JUMLAH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="14">TINDAK
                                LANJUT</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="4"
                                rowspan="2">KEWAJIBAN STOR PAJAK(PPN & PPh)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="4"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN DAERAH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="4"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN DESA</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="4"
                                rowspan="2">KEWAJIBAN SETOR KERUGIAN BLUD</th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="2">TEMUAN</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" rowspan="2">REKOMENDASI
                            </th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="7">
                                ADMINISTRASI</th>
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
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">JLH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BSR</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">BD</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">JLH</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">NILAI (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">DISETOR (Rp)</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">%</th>
                            <th class="border border-gray-300 px-1 py-1 dark:border-gray-700">SISA (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Baris header kecamatan --}}
                        <tr>
                            <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">1.</td>
                            <td class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="28">
                                {{ $kecamatanLabel }}</td>
                        </tr>

                        @foreach ($kampungRows as $kampung)
                            {{-- Baris header kampung (blank data) --}}
                            <tr>
                                <td class="border border-gray-300 px-1 py-1 dark:border-gray-700"></td>
                                <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $kampung['no'] }}.</td>
                                <td class="border border-gray-300 px-1 py-1 dark:border-gray-700" colspan="27">
                                    {{ $kampung['namaKampung'] }}</td>
                            </tr>

                            {{-- Baris per kasus (per tahun) --}}
                            @foreach ($kampung['rows'] as $data)
                                <tr>
                                    <td class="border border-gray-300 px-1 py-1 dark:border-gray-700"></td>
                                    <td class="border border-gray-300 px-1 py-1 dark:border-gray-700"></td>
                                    <td class="border border-gray-300 px-1 py-1 dark:border-gray-700">TP.
                                        {{ $data['tahun'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['temuanCount'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['rekomendasiCount'] }}</td>

                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['admin']['ssr'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['admin']['bsr'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['bd'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['admin']['bd'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['admin']['jumlah'] }}</td>

                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['ssr'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['keuangan']['ssr'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bsr'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['keuangan']['bsr'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['bd'] }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['ratios']['keuangan']['bd'] }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $data['keuangan']['jumlah'] }}</td>

                                    @php $ratioBk1 = $data['bk'][1] > 0 ? round($data['setoran'][1] / $data['bk'][1] * 100) : 0; @endphp
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][1]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][1]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $ratioBk1 }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][1]) }}</td>

                                    @php $ratioBk2 = $data['bk'][2] > 0 ? round($data['setoran'][2] / $data['bk'][2] * 100) : 0; @endphp
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][2]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][2]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $ratioBk2 }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][2]) }}</td>

                                    @php $ratioBk3 = $data['bk'][3] > 0 ? round($data['setoran'][3] / $data['bk'][3] * 100) : 0; @endphp
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][3]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][3]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $ratioBk3 }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][3]) }}</td>

                                    @php $ratioBk4 = $data['bk'][4] > 0 ? round($data['setoran'][4] / $data['bk'][4] * 100) : 0; @endphp
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['bk'][4]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['setoran'][4]) }}</td>
                                    <td class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                        {{ $ratioBk4 }}%</td>
                                    <td class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                        {{ $fmt($data['sisa'][4]) }}</td>
                                </tr>
                            @endforeach

                            {{-- Baris JUMLAH per kampung --}}
                            @php $t = $kampung['totals']; @endphp
                            <tr class="font-semibold">
                                <th class="border border-gray-300 px-1 py-1 dark:border-gray-700"></th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700"
                                    colspan="2">JUMLAH</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['temuan'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['rekomendasi'] }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['ssr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['admin']['ssr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['bsr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['admin']['bsr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['bd'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['admin']['bd'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['admin']['jumlah'] }}</th>

                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['ssr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['keuangan']['ssr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['bsr'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['keuangan']['bsr'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['bd'] }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['ratios']['keuangan']['bd'] }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $t['keuangan']['jumlah'] }}</th>

                                @php $tRatioBk1 = $t['bk'][1] > 0 ? round($t['setoran'][1] / $t['bk'][1] * 100) : 0; @endphp
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][1]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][1]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $tRatioBk1 }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][1]) }}</th>

                                @php $tRatioBk2 = $t['bk'][2] > 0 ? round($t['setoran'][2] / $t['bk'][2] * 100) : 0; @endphp
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][2]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][2]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $tRatioBk2 }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][2]) }}</th>

                                @php $tRatioBk3 = $t['bk'][3] > 0 ? round($t['setoran'][3] / $t['bk'][3] * 100) : 0; @endphp
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][3]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][3]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $tRatioBk3 }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][3]) }}</th>

                                @php $tRatioBk4 = $t['bk'][4] > 0 ? round($t['setoran'][4] / $t['bk'][4] * 100) : 0; @endphp
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['bk'][4]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['setoran'][4]) }}</th>
                                <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                    {{ $tRatioBk4 }}%</th>
                                <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                    {{ $fmt($t['sisa'][4]) }}</th>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="31" class="bg-gray-100 px-1 py-1 dark:border-gray-700">&nbsp;</td>
                        </tr>

                        {{-- Baris TOTAL keseluruhan. Catatan: rasio SSR/BSR/BD di baris ini memakai
                             rasio admin/keuangan KESELURUHAN untuk ketiga kolom (bukan per-status),
                             direplikasi persis dari perilaku kode CI lama. --}}
                        @php $g = $grandTotal; @endphp
                        <tr class="font-semibold">
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700"
                                colspan="3">TOTAL</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['temuan'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['rekomendasi'] }}</th>

                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['admin']['ssr'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['admin']['ssr'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['admin']['bsr'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['admin']['bsr'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['admin']['bd'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['admin']['bd'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['admin']['jumlah'] }}</th>

                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['keuangan']['ssr'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['keuangan']['ssr'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['keuangan']['bsr'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['keuangan']['bsr'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['keuangan']['bd'] }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['ratios']['keuangan']['bd'] }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $g['keuangan']['jumlah'] }}</th>

                            @php $gRatioBk1 = $g['bk'][1] > 0 ? round($g['setoran'][1] / $g['bk'][1] * 100) : 0; @endphp
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['bk'][1]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['setoran'][1]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $gRatioBk1 }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['sisa'][1]) }}</th>

                            @php $gRatioBk2 = $g['bk'][2] > 0 ? round($g['setoran'][2] / $g['bk'][2] * 100) : 0; @endphp
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['bk'][2]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['setoran'][2]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $gRatioBk2 }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['sisa'][2]) }}</th>

                            @php $gRatioBk3 = $g['bk'][3] > 0 ? round($g['setoran'][3] / $g['bk'][3] * 100) : 0; @endphp
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['bk'][3]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['setoran'][3]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $gRatioBk3 }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['sisa'][3]) }}</th>

                            @php $gRatioBk4 = $g['bk'][4] > 0 ? round($g['setoran'][4] / $g['bk'][4] * 100) : 0; @endphp
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['bk'][4]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['setoran'][4]) }}</th>
                            <th class="border border-gray-300 px-1 py-1 text-center dark:border-gray-700">
                                {{ $gRatioBk4 }}%</th>
                            <th class="border border-gray-300 px-1 py-1 text-right dark:border-gray-700">
                                {{ $fmt($g['sisa'][4]) }}</th>
                        </tr>
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
        <button type="button" id="rekapapbkam-xlsx" data-tahun-pemeriksaan="{{ $filters['tahun_pemeriksaan'] }}"
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
