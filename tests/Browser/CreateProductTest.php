<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateProductTest extends DuskTestCase
{
    /**
     * Test creating a product.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->browse(function (Browser $browser) {
            $name = 'Test Product';
            $description = 'Testing Description';
            $style = 'Test Style';
            $brand = 'Test Brand';
            $type = 'Test Type';
            $browser->login()
                ->visit('/products/create')
                ->type('[name=product_name]', $name)
                ->type('[name=description]', $description)
                ->type('[name=style]', $style)
                ->type('[name=brand]', $brand)
                ->type('[name=product_type]', $type)
                ->press('CREATE')
                ->assertPathBeginsWith('/products/');

            $this->assertDatabaseHas('products', [
                'admin_id' => $this->user()->id,
                'product_name' => $name,
                'description' => $description,
                'style' => $style,
                'brand' => $brand,
                'product_type' => $type
            ]);
        });
    }

    /**
     * Test cancelling a product.
     *
     * @return void
     */
    public function testCancel()
    {
        $this->browse(function (Browser $browser) {
            $browser->login()->visit('/products/create')->clickLink('Cancel')->assertPathIs('/products');
        });
    }
}
