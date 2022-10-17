@extends('admin.layout.app')
@section('title', 'Order detail')
@section('content')

    <div class="container-fluid">
        <div class="col-md-12">
            <!-- DATA TABLE -->
            <div class="card w-50">
                <div class="card-body">
                    <div class="mb-3">
                        <h3 class="text-bold"><i class="fa-solid fa-clipboard me-3"></i>Order Info</h3>
                        <small class="text-warning"><i class="fa-solid fa-triangle-exclamation"></i>
                            Include Delivery Charges
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-6"><i class="fa-solid fa-user me-3"></i>User Name </div>
                        <div class="col-6">{{ $orderList[0]->user }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><i class="fa-solid fa-barcode me-3"></i>Order Code</div>
                        <div class="col-6">{{ $orderList[0]->order_code }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><i class="fa-regular fa-clock me-3"></i>Order Date</div>
                        <div class="col-6">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><i class="fa-solid fa-money-bill-1-wave me-3"></i>Total</div>
                        <div class="col-6">{{ $orderList[0]->total_price }} Kyats</div>
                    </div>
                    <div class="mt-2 t">
                        <a href="{{ route('admin#orderList') }}" class=" float-end">go back....</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive table-responsive-data2">
                @if (count($orderList) != 0)
                    <table class="table table-data2">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orderList as $o)
                                <tr class="tr-shadow">
                                    <td id="oid" class=" align-middle">
                                        {{ $o->id }}
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $o->productImage) }}" alt="" width="100">
                                    </td>
                                    <td>
                                        {{ $o->productName }}
                                    </td>
                                    <td>{{ $o->qty }}</td>
                                    <td>{{ $o->price }}</td>
                                    <td>
                                        {{ $o->total }}
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $orderList->links() }}
                    </div>
                @else
                    <h3 class="text-muted text-center mt-5">There is no Data</h3>
                @endif
            </div>
            <!-- END DATA TABLE -->
        </div>
    </div>

@endsection
