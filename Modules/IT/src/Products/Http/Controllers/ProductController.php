<?php

namespace Modules\IT\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\IT\Products\Actions\CreateProduct;
use Modules\IT\Products\Actions\DeleteProduct;
use Modules\IT\Products\Actions\UpdateProduct;
use Modules\IT\Products\Http\Requests\ListProductsRequest;
use Modules\IT\Products\Http\Requests\ProductRequest;
use Modules\IT\Products\Queries\ListProducts;
use Modules\IT\Products\Queries\FindProduct;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_products_index')->only('index');
        $this->middleware('check.permission:it_products_create')->only(['create', 'store']);
        $this->middleware('check.permission:it_products_show')->only('show');
        $this->middleware('check.permission:it_products_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_products_destroy')->only('destroy');
    }

    public function index(ListProductsRequest $request, ListProducts $products)
    {
        return view('it::products.index', ['products' => $products->handle($request->validated())]);
    }

    public function create()
    {
        return view('it::products.create');
    }

    public function store(ProductRequest $request, CreateProduct $create)
    {
        $create->handle($request->validated(), $request->user());

        return redirect()->route('it.products.index')->with('success', 'Product created successfully.');
    }

    public function show(int $product, FindProduct $find)
    {
        return view('it::products.show', ['product' => $find->handle($product)]);
    }

    public function edit(int $product, FindProduct $find)
    {
        return view('it::products.edit', ['product' => $find->handle($product)]);
    }

    public function update(ProductRequest $request, int $product, UpdateProduct $update)
    {
        $update->handle($product, $request->validated(), $request->user());

        return redirect()->route('it.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(int $product, DeleteProduct $delete)
    {
        $delete->handle($product, auth()->user());

        return redirect()->route('it.products.index')->with('success', 'Product and its assets deleted successfully.');
    }
}
