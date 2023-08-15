<?php

namespace App\Http\Controllers;

use App\Models\Products as Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use illuminate\View\View;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(5);
        return view('product.index', compact('products'))
        ->with('i',(request()->input('page', 1) - 1) *5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       $request->validate([
        'name' => 'required',
        'detail'=> 'requierd'
       ]);

       Product::create($request->all());

       return redirect()->route('products.index')
       ->with('success','product created succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product):View
    {
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product):view
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name'=>'requierd',
            'description'=>'required'
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')
        ->with('success', 'product update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
        ->with("success","product deleted successfully");
    }
}
