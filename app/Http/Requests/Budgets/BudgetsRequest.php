<?php

namespace App\Http\Requests\Budgets;

use Illuminate\Foundation\Http\FormRequest;

class BudgetsRequest extends FormRequest
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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'amount_limit' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'integer', 'in:0,1'],
            'notes' => ['nullable', 'string', 'max:65535'],
        ];
    }

    /**
     * Custom messages (opcional).
     */
    public function messages(): array
    {
        return [
            'amount_limit.min' => 'El límite debe ser un número mayor o igual a 0.',
        ];
    }
}
