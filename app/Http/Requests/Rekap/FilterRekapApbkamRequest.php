<?php

declare(strict_types=1);

namespace App\Http\Requests\Rekap;

use Illuminate\Foundation\Http\FormRequest;

final class FilterRekapApbkamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'tahun_pemeriksaan' => ['required'],
            'kode_unor'         => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahun_pemeriksaan.required' => 'Tahun pemeriksaan wajib diisi.',

            'kode_unor.required' => 'Wilayah wajib dipilih.',
        ];
    }


    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tahun_pemeriksaan' => 'Tahun pemeriksaan',
            'kode_unor'         => 'Nama Kecamatan',
        ];
    }
}
