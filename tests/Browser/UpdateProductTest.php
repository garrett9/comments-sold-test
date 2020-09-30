<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateProductTest extends DuskTestCase
{
    /**
     * Test creating a product.
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->browse(function (Browser $browser) {

            $product = Product::factory()->make();
            $this->user()->products()->save($product);

            $name = 'Update Test Product';
            $description = 'Testing Description';
            $style = 'Update Test Style';
            $brand = 'Update Test Brand';
            $type = 'Update Test Type';
            $browser->login()
                ->visit("/products/$product->id")
                ->assertValue('[name=product_name]', $product->product_name)
                ->assertValue('[name=description]', $product->description)
                ->assertValue('[name=style]', $product->style)
                ->assertValue('[name=brand]', $product->brand)
                ->assertValue('[name=product_type]', $product->product_type)
                ->type('[name=product_name]', $name)
                ->type('[name=description]', $description)
                ->type('[name=style]', $style)
                ->type('[name=brand]', $brand)
                ->type('[name=product_type]', $type)
                ->press('SAVE')
                ->assertPathIs("/products/$product->id")
                ->pause(3000);

            $this->assertDatabaseHas('products', [
                'id' => $product->id,
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
    public function testDelete()
    {
        $this->browse(function (Browser $browser) {
            $product = Product::factory()->make();
            $this->user()->products()->save($product);
            $browser->login()->visit("/products/$product->id")
                ->press('DELETE')
                ->waitForText("Are you sure")
                ->press('YES')
                ->waitForLocation('/products');

            $this->assertDatabaseMissing('products', [
                'id' => $product->id
            ]);
        });
    }
}
