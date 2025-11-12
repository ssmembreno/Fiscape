<?php

namespace App\Http\Requests\Accounts;

use Illuminate\Foundation\Http\FormRequest;

class AccountsRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'],
            'currency' => ['required', 'string', 'max:20'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function message(): array
    {
        return [
            'name.required' => 'El nombre de la cuenta es obligatorio.',
            'type.required' => 'Debes especificar el tipo de cuenta.',
            'currency.required' => 'Selecciona una divisa válida.',
            'balance.numeric' => 'El balance debe ser un número.',
            'balance.min' => 'El balance no puede ser negativo.',
        ];
    }
}
