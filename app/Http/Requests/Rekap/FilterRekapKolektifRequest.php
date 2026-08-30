<?php

declare(strict_types=1);

namespace App\Http\Requests\Rekap;

use Illuminate\Foundation\Http\FormRequest;

final class FilterRekapKolektifRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO: sesuaikan dengan gate/policy setelah modul auth & level user tersedia.
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'id_jenis_php'      => ['required', 'integer', 'exists:kis_jenis_phps,id_jenis_php'],
            'tahun_pemeriksaan' => ['required', 'string', 'max:20'],
            'kode_unor'         => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_jenis_php'      => 'Jenis PHP',
            'tahun_pemeriksaan' => 'Tahun pemeriksaan',
            'kode_unor'         => 'Obrik',
        ];
    }
}
