<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Delete the given product.
     *
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->to("/products");
    }

    /**
     * Return all products associated to the current user.
     */
    public function index()
    {
        return inertia('Products', [
            'products' => ProductResource::collection(request()->user()->products()->orderBy('product_name', 'asc')->paginate()->onEachSide(2))
        ]);
    }

    /**
     * Show the form for creating a new project for the current user.
     */
    public function showStore()
    {
        return inertia('CreateProduct');
    }

    /**
     * Show the form for updating a product.
     *
     * @return void
     */
    public function showUpdate(Product $product)
    {
        return inertia('UpdateProduct', [
            'product' => $product
        ]);
    }

    /**
     * Store a new product for the current user.
     *
     * @param Request $name
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $product = new Product($request->input());
        $request->user()->products()->save($product);

        return redirect()->to("/products/$product->id");
    }

    /**
     * Undocumented function
     *
     * @param  Request $request
     * @return void
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->fill($request->input());
        $product->save();

        return $this->showUpdate($product);
    }
}
