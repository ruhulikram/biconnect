<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reportable_type' => 'required|in:post,user',
            'reportable_id'   => 'required|integer',
            'reason'          => 'required|string|max:100',
            'detail'          => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required'          => 'Pilih alasan laporan.',
            'reportable_type.required' => 'Tipe laporan tidak valid.',
            'reportable_type.in'       => 'Tipe laporan harus post atau user.',
            'detail.max'               => 'Detail tambahan maksimal 500 karakter.',
        ];
    }
}
