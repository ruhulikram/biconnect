<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'         => ['required', 'in:discussion,project'],
            'title'        => ['required_if:type,project', 'nullable', 'string', 'max:150'],
            'body'         => ['required', 'string', 'min:10'],
            'skills'       => ['nullable', 'array'],
            'skills.*'     => ['exists:skills,id'],
            'deadline'     => ['nullable', 'date', 'after:today'],
            'campus_area'  => ['nullable', 'string', 'max:100'],
            'project_type' => ['nullable', 'in:paid,unpaid,portfolio'],
            'image'        => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'       => 'Tipe post harus dipilih.',
            'type.in'             => 'Tipe post tidak valid.',
            'title.required_if'   => 'Judul wajib diisi untuk post project.',
            'title.max'           => 'Judul maksimal 150 karakter.',
            'body.required'       => 'Konten post wajib diisi.',
            'body.min'            => 'Konten post minimal 10 karakter.',
            'skills.*.exists'     => 'Skill yang dipilih tidak valid.',
            'deadline.date'       => 'Format deadline tidak valid.',
            'deadline.after'      => 'Deadline harus setelah hari ini.',
            'image.image'         => 'File harus berupa gambar.',
            'image.max'           => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}
