<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'product_name' => $this->product_name,
            'total'        => '$' . number_format($this->total_cents / 100, 2, '.', ','),
            'order_status' => $this->order_status,
            'sku'          => $this->sku
        ];
    }
}