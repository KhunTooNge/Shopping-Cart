<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // sort product by asc and desc
    public function ajaxCall(Request $request)
    {
        if ($request->status == 'asc') {
            $data = Product::select('products.*', 'categories.name as category_name')
                ->join('categories', 'products.category_id', 'categories.id')->orderBy('products.id', 'asc')->get();

            return response()->json($data, 200);
        } else if ($request->status == 'desc') {
            $data = Product::select('products.*', 'categories.name as category_name')
                ->join('categories', 'products.category_id', 'categories.id')->orderBy('products.id', 'desc')->get();
            return response()->json($data, 200);
        }

    }
    // create cart by ajax (qty many)
    public function createCart(Request $request)
    {

        $this->addToCart($request);
        $response = [
            'message' => 'Add to cart complete',
            'status' => true,

        ];
        return response()->json($response, 200);
    }

    // create cart by one (qty one)
    public function addOneCart(Request $request)
    {

        $this->addToCart($request);
        $response = [
            'message' => 'Add to cart complete',
            'status' => true,

        ];
        return response()->json($response, 200);
    }

    // clear all cart by ajax
    public function clearAllCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['message' => 'success'], 200);
    }

    // clear cart by id when click cross btn
    public function clearCartById(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->where('id', $request->cart_id)->delete();

        return response()->json(['status' => true,
            'message' => 'cart deleted'], 200);
    }

    // cart data
    private function addCartData($request)
    {
        return [
            'user_id' => $request->customerId,
            'product_id' => $request->productId,
            'qty' => $request->qty,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    // conditional addto cart
    private function addToCart($request)
    {
        if (Cart::where('product_id', $request->productId)->where('user_id', $request->customerId)->doesntExist()) {
            $cart = $this->addCartData($request);
            $carts = Cart::create($cart);
        } else {
            $data = Cart::where('product_id', $request->productId)->where('user_id', $request->customerId)->first();
            Cart::where('product_id', $request->productId)->where('user_id', $request->customerId)->update([
                'qty' => $data->qty + $request->qty,
            ]);
        }
    }

    // role change user to admin
    public function roleChange(Request $request)
    {
        User::where('id', $request->id)->update([
            'role' => $request->role,
        ]);
        return response()->json(200);
    }

    // view count
    public function viewCount(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $countofview = [
            'view_count' => $product->view_count + 1,
        ];
        Product::where('id', $request->product_id)->update($countofview);
        return response()->json(200);
    }

}
