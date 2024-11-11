<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required',
            'identity' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama laporan wajib diisi',
            'identity.required' => 'Identitas wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'gender.required' => 'Jenis kelamin wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'fax.required' => 'Nomor fax wajib diisi',
        ];
    }
}
