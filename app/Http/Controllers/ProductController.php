<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Storage;

class ProductController extends Controller
{
    // product list page
    public function index()
    {

        $product = Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', 'categories.id')
            ->when(request('keys'), function ($query) {
                $query->where('products.name', 'like', '%' . request('keys') . '%')
                    ->orWhere('products.price', 'like', '%' . request('keys') . '%')->paginate(3);
            })->orderBy('id', 'desc')->paginate(3);

        $product->append(request()->all());
        return view('admin.products.index', compact('product'));

    }

    // product create page
    public function add()
    {
        $category = Category::select('id', 'name')->get();
        return view('admin.products.add', compact('category'));
    }

    // product 'create'
    public function create(Request $request)
    {
        $this->productValidationCheck($request, 'create');
        $data = $this->productData($request);
        if ($request->hasFile('image')) {
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        Product::create($data);
        return redirect()->route('product#list')->with(['message' => 'Product Created Successfuly']);
    }

    // product delete
    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
        // $product->image
        if (File::exists(public_path('storage/' . $product->image))) {
            File::delete(public_path('storage/' . $product->image));
        }
        Product::where('id', $id)->delete();
        return back()->with(['message' => 'Product data deleted']);
    }

    // product detail
    public function detail($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.products.detail', compact('product'));
    }

    // edit page
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.products.edit', compact('product', 'category'));
    }

    // update product
    public function update(Request $request)
    {

        $product = Product::where('id', $request->productId)->first();
        $dbImage = $product->image;

        $updateData = $this->productData($request);

        $this->productValidationCheck($request, 'update');

        if ($request->hasFile('image')) {

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $updateData['image'] = $fileName;
        }

        Product::where('id', $request->productId)->update($updateData);
        return redirect()->route('product#list')->with(['message' => 'Updated product!']);
    }

    // validation check product
    private function productValidationCheck($request, $status)
    {
        $validatorRuleCheck = [
            'productName' => 'required|min:5|unique:products,name,' . $request->productId,
            'productPrice' => 'required',
            'waitTime' => 'required',
            'description' => 'required|min:10',
            'category' => 'required',
        ];

        $validatorRuleCheck['image'] = $status == 'create' ? 'required|mimes:png,jpg,jpeg,webp|file' : 'mimes:png,jpg,jpeg,webp|file';
        Validator::make($request->all(), $validatorRuleCheck)->validate();
    }

    // create product data
    private function productData($request)
    {
        return [
            'name' => $request->productName,
            'price' => $request->productPrice,
            'description' => $request->description,
            'waiting_time' => $request->waitTime,
            'category_id' => $request->category,
        ];
    }
}
