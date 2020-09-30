<?php

namespace Tests\Browser;

use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrdersTest extends DuskTestCase
{
    /**
     * Return the query for retrieving orders.
     */
    private function orderQry()
    {
        return Order::select('orders.*', 'products.product_name', 'inventories.sku')
            ->join('inventories', 'inventories.id', '=', 'orders.inventory_id')
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->on('products.id', '=', 'orders.product_id');
            })
            ->where('products.admin_id', $this->user()->id)
            ->orderBy('products.product_name');
    }
    /**
     * Test viewing the order information on the page.
     *
     * @return void
     */
    public function testDataAndTable()
    {
        $this->browse(function (Browser $browser) {
            $browser->login()->visit('/orders')
                ->assertSee('Order Statuses');

            $qry = $this->orderQry();

            $browser->assertSeeIn('@totalOpen', (clone $qry)->where('order_status', 'open')->count());
            $browser->assertSeeIn('@totalPaid', (clone $qry)->where('order_status', 'paid')->count());
            $browser->assertSeeIn('@totalPending', (clone $qry)->where('order_status', 'pending')->count());
            $browser->assertSeeIn('@totalFulfilled', (clone $qry)->where('order_status', 'fulfulled')->count());
            $browser->assertSeeIn('@totalShipped', (clone $qry)->where('order_status', 'shipped')->count());

            $total = (clone $qry)->count();
            $browser->assertSeeIn('@totalOrders', $total);
            $browser->assertSeeIn('@totalRevenue', '$' . number_format((clone $qry)->sum('total_cents') / 100, 2, '.', ','));
            $browser->assertSeeIn('@orderAvg', '$' . number_format((clone $qry)->avg('total_cents') / 100, 2, '.', ','));

            $order = $qry->first();
            $browser->assertSee("Showing 10 of $total results.");
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(1)')->getText(), $order->name);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(2)')->getText(), $order->email);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(3)')->getText(), $order->product_name);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(4)')->getText(), $order->sku);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(5)')->getText(), $order->order_status);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(6)')->getText(), '$' . $order->total_cents / 100);
        });
    }

    /**
     * Test clicking the link to view an order.
     *
     * @return void
     */
    public function testViewOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->login()
                ->visit('/orders');

            $order = $this->orderQry()->first();
            $browser->within('tbody tr:first-child', function (Browser $browser) use ($order) {
                $browser->clickLink('View');
            })->waitForText('Product Details')->assertPathIs("/orders/$order->id");
        });
    }
}
