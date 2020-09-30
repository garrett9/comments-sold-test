<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductsTest extends DuskTestCase
{
    /**
     * Test viewing the Products table.
     *
     * @return void
     */
    public function testTableView()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->login()
                ->visit('/')
                ->assertPathIs('/products')
                ->assertSee('Products');

            $product = $this->user()->products()->orderBy('product_name')->first();
            $total = $this->user()->products()->count();
            $browser->assertSee("Showing 10 of $total results.");
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(1)')->getText(), $product->product_name);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(2)')->getText(), $product->style);
            $this->assertEquals($browser->element('tbody tr:first-child > td:nth-child(3)')->getText(), $product->brand);
        });
    }

    /**
     * Test opening the page for updating a product.
     *
     * @return void
     */
    public function testOpenEditPage()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->login()
                ->visit('/products');

            $product = $this->user()->products()->orderBy('product_name')->first();
            $browser->within('tbody tr:first-child', function (Browser $browser) {
                $browser->clickLink('Edit');
            })->waitForText('Product Details')->assertPathIs("/products/$product->id");
        });
    }
}
