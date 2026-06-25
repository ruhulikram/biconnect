<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'bio'         => 'nullable|string|max:500',
            'program'     => 'nullable|string|max:100',
            'semester'    => 'nullable|integer|min:1|max:14',
            'campus_area' => 'nullable|string|max:100',
            'avatar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'skills'      => 'nullable|array',
            'skills.*'    => 'exists:skills,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'   => 'Nama lengkap wajib diisi.',
            'name.max'        => 'Nama tidak boleh lebih dari 100 karakter.',
            'bio.max'         => 'Bio tidak boleh lebih dari 500 karakter.',
            'avatar.image'    => 'File avatar harus berupa gambar.',
            'avatar.max'      => 'Ukuran avatar maksimal 2MB.',
            'cover.image'     => 'File sampul harus berupa gambar.',
            'cover.max'       => 'Ukuran sampul maksimal 4MB.',
            'skills.*.exists' => 'Skill yang dipilih tidak valid.',
        ];
    }
}
