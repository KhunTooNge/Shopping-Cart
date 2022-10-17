@extends('user.layout.master')
@section('title', 'MultiShop - Online Shop')
@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter
                        by price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <h4 class="text-center mb-3">Search Products</h4>
                    <form action="{{ route('searchByPrice') }}" method="GET">
                        <input type="number" name="price1" class="form-control mb-2" placeholder="enter min price">
                        <input type="number" name="price2" class="form-control mb-2" placeholder="enter max price">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                </div>
                <!-- Price End -->
                <div class="mb-3">
                    <button class="btn btn btn-warning w-100" disabled>Thanks You</button>
                </div>
                <!-- Size End -->

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#addToCart') }}">
                                    <button type="button" class="btn btn-primary position-relative">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger "
                                            id="countofCart">
                                            {{ count($cart) }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>
                                <a href="{{ route('user#history') }}" class="ms-3">
                                    <button type="button" class="btn btn-primary position-relative">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($order) }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>

                            </div>
                            <div class="ml-2">
                                <select class="form-select" aria-label="Default select example" id="sorting">
                                    <option value="">Choose </option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="detail.html"> --}}
                    <div class="row" id="productGoThere">
                        @if (count($data) != 0)
                            @foreach ($data as $product)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100 shadow-md"
                                                src="{{ asset('storage/' . $product->image) }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square addOne"><i
                                                        class="fa fa-shopping-cart"></i></a>

                                                <form action="{{ route('user#product#detail') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="pid" value="{{ $product->id }}"
                                                        id="proproid">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" id="cid">
                                                    <a class="btn btn-outline-dark btn-square">
                                                        <button type="submit" class="btn">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </button>
                                                    </a>
                                                    <input type="hidden" name="cateid"
                                                        value="{{ $product->category_id }}">

                                                </form>

                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate">{{ $product->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $product->price }} kyats</h5>
                                                {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                <p> <img src="{{ asset('images/icon/noData.jpg') }}" class="img-fluid"></p>
                                <h5 class="text-center">There is no data</h5>
                            </div>

                        @endif

                    </div>


                    </a>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            $('#sorting').change(function() {
                $eventOption = $('#sorting').val();
                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/pizza/list',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(res) {
                            $list = '';
                            for ($i = 0; $i < res.length; $i++) {
                                $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100 shadow-md"
                                            src="{{ asset('storage/${res[$i].image}') }}" alt=""
                                            style="height: 180px">
                                            <input type="hidden" value="{{ Auth::user()->id }}" id="cid">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square ">
                                                <i class="fa-solid fa-heart"></i>
                                            </a>

                                            <form action="{{ route('user#product#detail') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="pid" value="${res[$i].id}" id="proproid">
                                                <a class="btn btn-outline-dark btn-square">
                                                    <button type="submit" class="btn">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                </a>

                                            </form>

                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">${res[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${res[$i].price} kyats</h5>
                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                                $('#productGoThere').html($list)
                            }
                        }
                    })
                } else {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(res) {
                            $list = '';
                            for ($i = 0; $i < res.length; $i++) {
                                $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100 shadow-md"
                                            src="{{ asset('storage/${res[$i].image}') }}" alt=""
                                            style="height: 180px">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square ">
                                                <i class="fa-solid fa-heart"></i>
                                            </a>
                                            <form action="{{ route('user#product#detail') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="pid" value=" ${res[$i].id}" id="proproid">
                                                <input type="hidden" value="{{ Auth::user()->id }}" id="cid">
                                                <a class="btn btn-outline-dark btn-square">
                                                    <button type="submit" class="btn">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </button>
                                                </a>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">${res[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${res[$i].price} kyats</h5>
                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                                $('#productGoThere').html($list)
                            }
                        }
                    })
                }

            })

            $('.addOne').click(function() {
                $productId = $(this).parents('.product-action').find('#proproid').val();
                $customerId = $(this).parents('.product-action').find('#cid').val();
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/addOneCart',
                    data: {
                        customerId: $customerId,
                        productId: $productId,
                        qty: 1,
                    },
                    dataType: 'json',
                    success: function(res) {
                        location.reload();
                    }
                })
            })
        })
    </script>
@endsection
