<?php

namespace App\Http\Requests;

use App\Rules\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:users,name|max:255|min:8',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'required_with:password_confirmation', 'same:password_confirmation', new StrongPassword],
            'password_confirmation' => 'min:8'
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
