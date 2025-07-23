<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'street'      => 'sometimes|required|string|max:255',
            'city'        => 'sometimes|required|string|max:100',
            'state'       => 'sometimes|required|string|max:100',
            'zip_code' => 'sometimes|required|string|max:20',
            'country'     => 'sometimes|required|string|max:100',
            'number' => 'sometimes|required|string|max:255',
            'is_default'  => 'sometimes|boolean',
        ];
    }
}
