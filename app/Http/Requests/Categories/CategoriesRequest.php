<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'descripcion' => 'nullable| max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'El nombre es obligatorio',
            'descripcion' => 'La descripción no puede contener mas de 255 caracteres'
        ];
    }
}
