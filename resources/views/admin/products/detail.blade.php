@extends('admin.layout.app');
@section('title', 'profile');
@section('content')
    <div class="container-fluid">
        <i class="fa-solid fa-circle-left m-3" onclick="history.back()"></i>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-title">
                        <h2 class="font-weight-light text-center py-3">Product Info</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 mt-3">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="John Doe" class=" img-fluid" />

                                <a href="{{ route('product#edit', $product->id) }}" class="d-flex justify-content-center">
                                    <button class="btn  btn-dark mt-3 rounded-pill"><i
                                            class="fa-solid fa-pen-to-square pr-3"></i>Edit Profile</button>
                                </a>
                            </div>
                            <div class="col-5 offset-1">
                                <p class="my-3">
                                    <button class="btn btn-danger">{{ $product->name }}</button>
                                </p>

                                <span class="bg-dark text-white   d-inline-block m-1 px-2">
                                    <i class="fa-solid fa-money-bill-wave pr-1"></i>{{ $product->price }} kyats
                                </span>

                                <span class="bg-dark text-white d-inline-block m-1 px-2">
                                    <i class="fa-solid fa-user-clock pr-1"></i> {{ $product->created_at->format('j F Y') }}
                                </span>

                                <span class="bg-dark text-white  d-inline-block m-1 px-2">
                                    <i class="fa-solid fa-clock  pr-1"></i> {{ $product->waiting_time }} mins
                                </span>

                                <span class="bg-dark text-white    d-inline-block m-1 px-2">
                                    <i class="fa-solid fa-eye pr-1"></i>{{ $product->view_count }}
                                </span>

                                <span class="bg-dark text-white  d-inline-block m-1 px-2">
                                    <i class="fa-solid fa-layer-group pr-1"></i> {{ $product->category_name }}
                                </span>

                                <div class="my-2">
                                    <h3>
                                        <i class="fa-solid fa-book-bookmark pr-1 d-inline-block m-1"></i> details
                                    </h3>
                                </div>

                                <p class="">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
