@extends('user.layout.master')
@section('title', 'details page')
@section('content')

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <img class="w-100 h-100" src="{{ asset('storage/' . $product->image) }}" alt="Image">
            </div>

            {{-- <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product->image) }}" alt="Image">
                        </div>
                        @foreach ($data as $d)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ asset('storage/' . $d->image) }}" alt="Image">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div> --}}

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product->name }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">{{ $product->view_count + 1 }} view</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $product->price }} kyats</h3>
                    <p class="mb-4 text-justify">
                        {{ $product->description }}
                    </p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="number" class="form-control bg-secondary border-0 text-center" value="1"
                                id="orderCount" max="15">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" value="{{ $product->id }}" id="pid">
                        <input type="hidden" value="{{ Auth::user()->id }}" id="cid">

                        <a href="{{ route('user#home') }}">
                            <button class="btn btn-primary px-3" type="button" id="addCart">
                                <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                            </button>
                        </a>


                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel" id="parentdiv">
                    @foreach ($data as $d)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $d->image) }}" alt=""
                                    style="height: 180px;">
                                <div class="product-action">

                                    <a class="btn btn-outline-dark btn-square"><i class="fa fa-heart"></i>
                                    </a>

                                    <form action="{{ route('user#product#detail') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="pid" value="{{ $d->id }}">
                                        <a class="btn btn-outline-dark btn-square">
                                            <button type="submit" class="btn">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>
                                        </a>
                                    </form>

                                </div>
                            </div>

                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $d->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $d->price }} Kyats</h5>
                                    {{-- <h6 class="text-muted ml-2"><del>$123.00</del></h6> --}}
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            //view count
            $.ajax({
                type: 'get',
                url: 'http://127.0.0.1:8000/user/ajax/viewCount',
                dataType: 'json',
                data: {
                    product_id: $('#pid').val()
                },
                success: function(res) {
                    console.log(res);
                }
            })
            // add to cart
            $('#addCart').click(function() {

                $data = {
                    'productId': $('#pid').val(),
                    'customerId': $('#cid').val(),
                    'qty': $('#orderCount').val()
                }
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/cart',
                    dataType: 'json',
                    data: $data,
                    success: function(res) {
                        console.log(res.cartCount);
                    }
                })
            })
        })
    </script>
@endsection
