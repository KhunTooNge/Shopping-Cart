<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // user order list
    public function order(Request $request)
    {
        $total = 0;
        foreach ($request->all() as $item) {
            $data = OrderList::create(
                [
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'total' => $item['total'],
                    'order_code' => $item['order_code'],
                ]);
            $total += $data['total'];
        }
        logger($data['order_code']);
        Cart::where('user_id', Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total + 3000,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ], 200);
    }

    // admin order list
    public function index()
    {
        $order = Order::select('orders.*', 'users.id as uid', 'users.name as name')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->when(request('keys'), function ($query) {
                $query->where('orders.order_code', 'like', '%' . request('keys') . '%')
                    ->orWhere('users.name', 'like', '%' . request('keys') . '%')->paginate(5);
            })
            ->orderBy('created_at', 'desc')->paginate(5);
        $order->appends(request()->all());
        return view('admin.order.order_list', compact('order'));

    }

    // sorting by status pending success reject
    public function sortStatus(Request $request)
    {
        $order = Order::select('orders.*', 'users.id as uid', 'users.name as name')
            ->leftJoin('users', 'orders.user_id', 'users.id');

        if ($request->orderStatus == null) {
            $order = $order->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $order = $order->where('status', $request->orderStatus)->orderBy('created_at', 'desc')->paginate(5);
        }
        return view('admin.order.order_list', compact('order'));
    }

    // order list  or detail page
    public function detail($orderCode)
    {
        $orderList = OrderList::select('order_lists.*', 'users.name as user', 'products.name as productName', 'products.image as productImage', 'products.price as price', 'orders.total_price as total_price')
            ->join('orders', 'orders.order_code', 'order_lists.order_code')
            ->join('users', 'orders.user_id', 'users.id')
            ->join('products', 'order_lists.product_id', 'products.id')
            ->where('orders.order_code', $orderCode)->paginate(5);
        // dd($orderList->toArray());
        return view('admin.order.order_detail', compact('orderList'));
    }

    // change status in db by ajax
    public function changeStatus(Request $request)
    {
        Order::where('id', $request->order_id)->update([
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'success',
        ], 200);
    }

}
