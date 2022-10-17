@extends('user.layout.master')
@section('title', 'Add To Cart')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="tableBody">
                        @foreach ($cart as $item)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                            style="width: 80px;" class="ms-4 pe-3">
                                        <span class="pname">{{ $item->name }}</span>
                                        <input type="hidden" value="{{ $item->id }}" id="proid">
                                        <input type="hidden" value="{{ $item->cid }}" id="cid">
                                    </div>

                                </td>
                                <td class="align-middle" id="price">{{ $item->price }} Kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus minusbtn"
                                                style="cursor: pointer">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $item->Qty }}" id="quantity">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus plusbtn" style="cursor: pointer">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle " id="calPrice">{{ $item->price * $item->Qty }} Kyats</td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-danger remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>



            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="totalPrice">{{ $total }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">3000</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $total + 3000 }} Kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="checkOrder">
                            Proceed To Checkout
                        </button>

                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="allCartClear">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('scriptSource')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        $(document).ready(function() {
            $orderList = [];
            $('#checkOrder').click(function() {
                $random = Math.floor(Math.random() * 1000000001);
                $('#table tbody tr').each(function(index, tr) {
                    $num1 = Number($(tr).find('#price').text().replace('Kyats', ''));
                    $num2 = Number($(tr).find('#quantity').val());
                    $total2 = $num1 * $num2;

                    $orderList.push({
                        'product_id': $(tr).find('#proid').val(),
                        'qty': $num2,
                        'total': $total2,
                        'order_code': 'POS' + $random
                    });
                })

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/order/list',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == true) {
                            window.location.href = "http://127.0.0.1:8000/user/home"
                        }
                    }
                })
            });
            $('#allCartClear').click(function() {
                $('#table tbody tr').remove();
                $('#totalPrice').text('0 Kyats');
                $('#finalPrice').text('3000 Kyats');

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/clearAllCart',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                    }
                })
            });
            $('.remove').click(function() {
                $cartId = $(this).parents('tr').find('#cid').val();
                $productId = $(this).parents('tr').find('#proid').val();

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/clearCartById',
                    data: {
                        'cart_id': $cartId,
                        'product_id': $productId
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                    }
                })
            })
        })
    </script>
@endsection
