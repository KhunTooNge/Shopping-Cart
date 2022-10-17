@extends('admin.layout.app')
@section('title', 'Order List')
@section('content')

    <div class="container-fluid">
        <div class="col-md-12">
            <!-- DATA TABLE -->
            <div class="table-data__tool">
                <div class="table-data_tool_right">
                    <form class="form-header" action="{{ route('admin#orderList') }}" method="GET">
                        @csrf
                        <input class="au-input" type="text" name="keys" placeholder="Search for datas" />
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="table-data__tool-right">
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                        CSV download
                    </button>
                </div>

            </div>
            <div class="row align-items-center mb-4">
                <div class="col-5">
                    <form action="{{ route('admin#sortStatus') }}" method="get">
                        <div class="input-group rounded">
                            <span class="input-group-text bg-dark text-white">
                                <i class="fa fa-database mx-2 "></i> {{ $order->total() }}
                            </span>
                            <select name="orderStatus" class="form-select">
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == 0) selected @endif>Pending...</option>
                                <option value="1" @if (request('orderStatus') == 1) selected @endif>Success</option>
                                <option value="2" @if (request('orderStatus') == 2) selected @endif>Reject</option>
                            </select>
                            <span class="input-group-text bg-dark text-white">
                                <button type="submit" class="text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>Search
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>


            <div class="table-responsive table-responsive-data2">
                @if (count($order) != 0)
                    <table class="table table-data2">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>ORDER_CODE</th>
                                <th>ORDER_DATE</th>
                                <th>USER_ID</th>
                                <th>TOTAL PRICE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="itemGoHere">
                            @forelse ($order as $o)
                                <tr class="tr-shadow">
                                    <td id="oid" class=" align-middle">
                                        {{ $o->id }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin#detail', $o->order_code) }}" class=" text-decoration-none">
                                            {{ $o->order_code }}</a>
                                    </td>
                                    <td>
                                        {{ $o->created_at->format('F-j-Y') }}
                                    </td>
                                    <td>{{ $o->name }}</td>
                                    <td>{{ $o->total_price }}</td>
                                    <td>
                                        <select class="form-select changeStatus">
                                            <option value="0" @if ($o->status == '0') selected @endif>
                                                Pending...</option>
                                            <option value="1" @if ($o->status == '1') selected @endif>Success
                                            </option>
                                            <option value="2" @if ($o->status == '2') selected @endif>Reject
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $order->links() }}
                    </div>
                @else
                    <h3 class="text-muted text-center mt-5">There is no Data</h3>
                @endif
            </div>
            <!-- END DATA TABLE -->
        </div>
    </div>

@endsection
@section('scriptSection')
    <script>
        $(document).ready(function() {
            $('.changeStatus').change(function() {
                $getStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = jQuery.trim($parentNode.find('#oid').text());

                $data = {
                    'status': $getStatus,
                    'order_id': $orderId
                }

                // console.log($data);
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/order/ajax/changeStatus',
                    data: $data,
                    dataType: 'json',
                })
            })
            // $('#orderStatus').change(function() {
            //     $status = $(this).val();
            //     $.ajax({
            //         type: 'get',
            //         url: 'http://127.0.0.1:8000/order/ajax',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success: function(res) {
            //             $list = '';
            //             for (let $i = 0; $i < res.data.length; $i++) {
            //                 $fullMonth = ['January', 'February', 'March', 'April', 'May',
            //                     'June', 'July', 'August', 'Setember', 'October', 'November',
            //                     'December'
            //                 ];

            //                 $dbDate = new Date(res.data[$i].created_at);
            //                 $year = $dbDate.getFullYear();
            //                 $day = $dbDate.getDate();
            //                 $month = $fullMonth[$dbDate.getMonth()];
            //                 $createdDate = $month + '-' + $day + '-' + $year;

            //                 if (res.data[$i].status == 0) {
            //                     $statusCheck = `<option value="0" selected >Pending...</option>
        //                     <option value="1">Success</option>
        //                     <option value="2">Reject</option>`
            //                 } else if (res.data[$i].status == 1) {
            //                     $statusCheck = `<option value="0"  >Pending...</option>
        //                     <option value="1" selected>Success</option>
        //                     <option value="2">Reject</option>`
            //                 } else if (res.data[$i].status == 2) {
            //                     $statusCheck = `<option value="0"  >Pending...</option>
        //                     <option value="1" >Success</option>
        //                     <option value="2" selected>Reject</option>`
            //                 }

            //                 $list += `<tr class="tr-shadow">
        //                     <td id="oid">
        //                          ${res.data[$i].id}
        //                     </td>
        //                     <td>
        //                         <span class="block-email">${res . data[$i] . order_code} </span>
        //                     </td>
        //                     <td>
        //                        ${$createdDate}
        //                     </td>
        //                     <td> ${res.data[$i].name} </td>
        //                     <td> ${res.data[$i].total_price} </td>
        //                     <td>
        //                         <select id="" class="form-select changeStatus">
        //                             ${$statusCheck}
        //                         </select>
        //                     </td>
        //                 </tr>
        //                 <tr class="spacer"></tr>`;

            //             }

            //             $('#itemGoHere').html($list);
            //         }
            //     })
            // });

        })
    </script>
@endsection
