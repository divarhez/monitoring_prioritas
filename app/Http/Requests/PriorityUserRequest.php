<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriorityUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Middleware role:admin already restricts access; allow here
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position'   => 'required|string|max:255',
            'phone'      => ['required','string','max:20','regex:/^[0-9+\-\s()]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama wajib diisi.',
            'department.required'  => 'Departemen wajib diisi.',
            'position.required'    => 'Jabatan wajib diisi.',
            'phone.required'       => 'Nomor telepon wajib diisi.',
            'phone.regex'          => 'Format nomor telepon tidak valid.',
        ];
    }
}
