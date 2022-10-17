@extends('admin.layout.app')
@section('title', ' Add Product')
@section('content')
    <div class="container-fluid">
        <div class="col-lg-10 offset-1 ">
            <div class="mb-2 ">
                <a href="{{ route('product#list') }}"> <button class="btn btn-info px-3">List</button></a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Product Form</h3>
                    </div>
                    <hr>


                    {{-- form start --}}
                    <form action="{{ route('product#create') }}" method="post" novalidate="novalidate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productName" class="control-label mb-1">Product Name</label>
                                    <input id="productName" name="productName" value="{{ old('productName') }}"
                                        type="text"
                                        class="form-control
                                        @error('productName') is-invalid @enderror"
                                        aria-required="true" aria-invalid="false">

                                    @error('productName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="productPrice" class="control-label mb-1">Price </label>
                                    <input id="productPrice" name="productPrice" value="{{ old('productPrice') }}"
                                        type="number"
                                        class="form-control
                                        @error('productPrice') is-invalid
                                        @enderror"
                                        aria-required="true" aria-invalid="false">

                                    @error('productPrice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Image </label>
                            <input id="image" name="image" type="file"
                                class="form-control
                                @error('image') is-invalid
                                @enderror"
                                aria-required="true" aria-invalid="false">

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="control-label mb-1">Category</label>
                                    <select
                                        class="form-select form-control
                                    @error('category') is-invalid
                                    @enderror "
                                        name="category" value="{{ old('category') }}" aria-label="Default select example">
                                        <option value="">Choose Option</option>
                                        @foreach ($category as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>


                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="waitTime" class="control-label mb-1">Waiting Time </label>
                                    <input id="waitTime" name="waitTime" value="{{ old('waitTime') }}" type="number"
                                        class="form-control
                                        @error('waitTime') is-invalid @enderror"
                                        aria-required="true" aria-invalid="false">

                                    @error('waitTime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label mb-1">Description </label>
                            <textarea name="description" id="" cols="30" rows="4"
                                class="form-control
                                @error('description') is-invalid
                                @enderror"
                                aria-required="true" aria-invalid="false">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                <i class="fa fa-plus mr-2"></i>
                                <span id="payment-button-amount">Add Products </span>
                            </button>
                        </div>

                    </form>
                    {{-- the end of the form --}}
                </div>
            </div>
        </div>
    </div>

@endsection
