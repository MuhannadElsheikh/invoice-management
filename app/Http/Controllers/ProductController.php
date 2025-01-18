<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products= Product::all();
        $sections = Section::all();
        return view('product.index', compact('products', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string',
            'description' => 'nullable|string',
        ], [
            'product_name.required' => 'يرجى اضافة اسم المنتج',

        ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);
        return redirect()->route('product.index')->with('status', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Section::where('section_name',$request->section_name)->first()->id;
        $products = Product::findOrfail($request->pro_id);

        $products->update([
            'product_name' => $request->product_name,
            'section_name' => $id,
            'description' => $request->description

        ]);
        return redirect()->route('product.index')->with('status', 'تم إضافة المنتج بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return redirect()->route('product.index')->with('status', 'تم حذف القسم بنجاح');
    }
}
