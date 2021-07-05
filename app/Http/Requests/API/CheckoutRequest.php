<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'number' => 'required|max:255',
            'address' => 'required',
            'transaction_total' => 'required|integer',

            // hanya boleh status yang ada di in, selain itu tidak valid
            'transaction_status' => 'nullable|string|in:PENDING,SUCCESS, FAILED',

            'transaction_details' => 'required|array',

            // ini untuk akses array nya dan datanya ada di tabel products
            'transaction_details.*' => 'integer|exists:products,id'
        ];
    }
}
