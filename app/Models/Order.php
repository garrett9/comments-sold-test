<?php

namespace App\Models;

class Order extends Model
{
    /**
     * Return the inventory relationship associated to the order.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Return the product relationship associated to the order.
     *
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}