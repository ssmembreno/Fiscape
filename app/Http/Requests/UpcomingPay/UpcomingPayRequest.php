<?php

namespace App\Http\Requests\UpcomingPay;

use Illuminate\Foundation\Http\FormRequest;

class UpcomingPayRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:1,0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'account_id.required' => 'La cuenta es obligatoria.',
            'category_id.required' => 'La categoría es obligatoria.',
            'amount.required' => 'El monto es obligatorio.',
            'due_date.required' => 'La fecha de vencimiento es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
        ];
    }
}
