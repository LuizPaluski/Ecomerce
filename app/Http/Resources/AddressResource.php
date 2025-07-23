<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'street'      => $this->street,
                'city'        => $this->city,
                'state'       => $this->state,
                'zip_code' => $this->zip_code,
                'country'     => $this->country,
                'number' => $this->number,
                'is_default'  => (bool) $this->is_default,
            ],
            'meta' => [
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ]
        ];
    }
}
