<?php

declare(strict_types=1);

namespace App\Http\Requests\Rekap;

use Illuminate\Foundation\Http\FormRequest;

final class FilterRekapPertahunRequest extends FormRequest
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
            'id_jenis_php' => ['required', 'integer', 'exists:kis_jenis_phps,id_jenis_php'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'id_jenis_php' => 'Jenis PHP',
        ];
    }
}
