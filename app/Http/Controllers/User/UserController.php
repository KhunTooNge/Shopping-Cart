<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Storage;

class UserController extends Controller
{
    // user home page
    public function home()
    {
        $data = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('data', 'category', 'cart', 'order'));
    }

    // product filter by category
    public function filterCategory($id)
    {
        $data = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('data', 'category', 'cart', 'order'));
    }

    // search by price
    public function searchByPrice(Request $request)
    {
        $min = $request->price1;
        $max = $request->price2;
        $data = Product::select('*');

        if (!is_null($min) && !is_null($max)) {
            $data = $data->where('price', '>=', $min)
                ->where('price', '<=', $max);
        } elseif (is_null($min) && !is_null($max)) {
            $data = $data->where('price', '<=', $max);
        } elseif (!is_null($min) && is_null($max)) {
            $data = $data->where('price', '>=', $min);
        }

        $data = $data->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('data', 'category', 'cart', 'order'));
    }

    // detail page
    public function detail()
    {
        $id = request('pid');
        $product = Product::where('id', $id)->first();
        $data = Product::orderBy('created_at', 'desc')->limit(3)->get();
        return view('user.main.detail', compact('product', 'data'));
    }

    // Add to Cart page
    public function addToCart()
    {
        $cart = Cart::select('products.*', 'carts.qty as Qty', 'carts.id as cid')
            ->join('products', 'carts.product_id', 'products.id')
            ->where('user_id', Auth::user()->id)
            ->get();

        $total = 0;
        foreach ($cart as $c) {
            $total += ($c->price * $c->Qty);
        }
        return view('user.main.addtocart', compact('cart', 'total'));
    }

    // user order history
    public function history()
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
        return view('user.main.history', compact('order'));
    }
    // user password change page
    public function passwordChange()
    {
        return view('user.main.password');
    }

    // user update password
    public function passwordUpdate(Request $request)
    {
        $this->validatePassCheck($request);

        $db = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->oldPassword, $db->password)) {
            $updatePass = Hash::make($request->newPassword);

            $data = [
                'password' => $updatePass,
            ];

            User::where('id', Auth::user()->id)->update($data);
            return back()->with(['success' => 'Password Change Success']);

        }

        return back()->with(['message' => 'Password Not Found.Do You Remember Password']);

    }

    // edit profile page
    public function editProfile()
    {
        return view('user.main.edit_profile');
    }

    // update profile page
    public function updateUser(Request $request)
    {
        $this->validateProfileCheck($request);
        $user = User::where('id', Auth::user()->id)->first();
        $updateData = $this->insertUpdateData($request);
        if ($request->hasFile('image')) {
            if ($user->image != null) {
                Storage::delete('public/' . $user->image);
            }

            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $updateData['image'] = $fileName;
        }

        User::where('id', Auth::user()->id)->update($updateData);
        return back()->with(['message' => 'Update Success']);
    }

    // update
    private function insertUpdateData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }

    // password vaidate check
    private function validatePassCheck($request)
    {
        return Validator::make($request->all(), [
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'confirmPassword.same' => 'The confirm password and new password much be same',
        ])->validate();
    }

    // profile validate check
    private function validateProfileCheck($request)
    {

        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();

    }

    // admin/ user list
    public function customerList()
    {
        $user = User::when(request('keys'), function ($query) {
            $query->where('name', 'like', '%' . request('keys') . '%')
                ->orWhere('email', 'like', '%' . request('keys') . '%')
                ->orWhere('phone', 'like', '%' . request('keys') . '%')
                ->orWhere('address', 'like', '%' . request('keys') . '%')
                ->orWhere('gender', 'like', '%' . request('keys') . '%')
                ->where('role', 'user');
        })->where('role', 'user')->paginate(10);
        $user->appends(request()->all());
        return view('admin.customer.list', compact('user'));
    }

    // admin/ delete user
    public function customerDelete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['message' => 'Customer delete success']);
    }

}
