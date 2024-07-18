<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam amount number required The amount to deposit. Example: 50000.00
 * @bodyParam timestamp string required The timestamp of the transaction. Example: 2024-07-20 12:34:56
 */
class TransactionRequest extends FormRequest
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
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'timestamp' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
