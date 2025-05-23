<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class OrderRequest extends FormRequest
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
            // 'user_id' => 'required|exists:users,id',
            'total_price' => 'nullable|decimal:0,2',
            'num_people' => 'required|integer',
            'special_request_id' => 'nullable|string|exists:order_notes,order_note_id|max:255',
            'customer_name' => 'required|string|max:255',
            'order_date' => 'required|date|after_or_equal:today',
            'order_time' => 'required|date_format:H:i',
            'party_id' => 'required|exists:parties,party_id',
            'phone_number' => 'required|string|max:15',
            'status' => 'integer|in:-2,-1,0,1,2,3,4,5',
            // 'order_id' => 'required|exists:orders,id',
            // 'menu_id' => 'required|exists:menus,id',
            // 'quantity' => 'required|integer|min:1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
