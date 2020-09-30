<?php

namespace Tests\Browser;

use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewOrderTest extends DuskTestCase
{
    /**
     * Test viewing an order.
     *
     * @return void
     */
    public function testShow()
    {
        $this->browse(function (Browser $browser) {
            $order = Order::whereHas('product', function ($qry) {
                $qry->where('admin_id', $this->user()->id);
            })->first();

            $browser->login()->visit("/orders/$order->id")
                ->assertValue('[name=id]', $order->id)
                ->assertValue('[name=name]', $order->name)
                ->assertValue('[name=email]', $order->email)
                ->assertValue('[name=order_status]', $order->order_status)
                ->assertValue('[name=total]', '$' . $order->total_cents / 100)
                ->assertValue('[name=shipper_name]', $order->shipper_name)
                ->assertValue('[name=tracking_number]', $order->tracking_number)
                ->assertValue('[name=product_name]', $order->product->product_name)
                ->assertValue('[name=product_type]', $order->product->product_type)
                ->assertValue('[name=color]', $order->inventory->color)
                ->assertValue('[name=size]', $order->inventory->size)
                ->assertValue('[name=sku]', $order->inventory->sku);
        });
    }
}
