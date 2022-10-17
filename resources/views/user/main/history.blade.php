@extends('user.layout.master')
@section('title', 'MultiShop - Online Shop')
@section('content')
    <div class="row">
        <div class="col-lg-8 offset-2 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Order Date</th>
                        <th>OrderCode</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="align-middle" id="tableBody">
                    @foreach ($order as $o)
                        <tr>
                            <td class="align-middle">
                                {{ $o->created_at->format('F-j-Y') }}
                            </td>
                            <td class="align-middle">
                                {{ $o->order_code }}
                            </td>
                            <td class="align-middle " id="calPrice">{{ $o->total_price }} Kyats</td>
                            <td>
                                @if ($o->status == 0)
                                    <span class="text-primary">
                                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Pending...
                                    </span>
                                @elseif ($o->status == 1)
                                    <span class="text-success">
                                        <i class="fa-solid fa-check  me-2"></i>Success
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Reject
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $order->links() }}
            </div>

        </div>
    </div>

@endsection
