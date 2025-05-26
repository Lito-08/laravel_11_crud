<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
 $request->validate([
 'code' => 'required|unique:products,code',
 'name' => 'required',
 'quantity' => 'required|integer',
 'price' => 'required|numeric',
 'description' => 'nullable',
 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
 ]);

 $data = [
 'code' => $request->code,
 'name' => $request->name,
 'quantity' => $request->quantity,
 'price' => $request->price,
 'description' => $request->description,
 ];

 if ($request->hasFile('image')) {
 $data['image'] = $request->file('image')->store('products', 'public');
 }

 Product::create($data);

 return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
 $request->validate([
 'code' => 'required|unique:products,code,' . $product->id,
 'name' => 'required',
 'quantity' => 'required|integer',
 'price' => 'required|numeric',
 'description' => 'nullable',
 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
 ]);

 $data = [
 'code' => $request->code,
 'name' => $request->name,
 'quantity' => $request->quantity,
 'price' => $request->price,
 'description' => $request->description,
 ];

 if ($request->hasFile('image')) {
 if ($product->image) {
 Storage::disk('public')->delete($product->image);
 }
 $data['image'] = $request->file('image')->store('products', 'public');
 } else {
 $data['image'] = $product->image;
 }

 $product->update($data);

 return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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
