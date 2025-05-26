<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class ProductController extends Controller
{
 /**
 * Display a listing of the resource.
 */
 public function index() : View
 {
 return view('products.index', [
 'products' => Product::latest()->paginate(4)
 ]);
 }
 /**
 * Show the form for creating a new resource.
 */
 public function create() : View
 {
 return view('products.create');
 }
 /**
 * Store a newly created resource in storage.
 */
 public function store(Request $request) : RedirectResponse
 {
 $validated = $request->validate([
 'code' => 'required',
 'name' => 'required',
 'quantity' => 'required|integer',
 'price' => 'required|numeric',
 'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
 ]);

 if ($request->hasFile('image')) {
 $validated['image'] = $request->file('image')->store('products', 'public');
 }

 Product::create($validated);

 return redirect()->route('products.index')
 ->withSuccess('New product is added successfully.');
 }
 /**
 * Display the specified resource.
 */
 public function show(Product $product) : View
 {
 return view('products.show', compact('product'));
 }
 /**
 * Show the form for editing the specified resource.
 */
 public function edit(Product $product) : View
 {
 return view('products.edit', compact('product'));
 }
 /**
 * Update the specified resource in storage.
 */
 public function update(Request $request, Product $product) : RedirectResponse
 {
 $validated = $request->validate([
 'code' => 'required',
 'name' => 'required',
 'quantity' => 'required|integer',
 'price' => 'required|numeric',
 'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
 ]);

 if ($request->hasFile('image')) {
 // Optionally delete old image here
 $validated['image'] = $request->file('image')->store('products', 'public');
 }

 $product->update($validated);

 return redirect()->route('products.index')
 ->withSuccess('Product is updated successfully.');
 }
 /**
 * Remove the specified resource from storage.
 */
 public function destroy(Product $product) : RedirectResponse
 {
 $product->delete();
 return redirect()->route('products.index')
 ->withSuccess('Product is deleted successfully.');
 }
}