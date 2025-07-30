<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'address_id' => [
                'required',

                Rule::exists('addresses', 'id')->where('user_id', auth()->id()),
            ],
            'discount_code' => 'nullable|string|max:255',

            'coupon_code' => [
                'nullable',
                'string',
                'max:255',
                Rule::exists('coupons', 'code'),
            ],
        ];
    }
}
