@extends('admin.layout.app')
@section('title', 'Add Category')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 offset-8">
                <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
            </div>
        </div>
        <div class="col-lg-6 offset-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Category Edit</h3>
                    </div>
                    <hr>

                    {{-- form start add category --}}
                    <form action="{{ route('category#update') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">

                            <label for="categoryName" class="control-label mb-1">Name</label>
                            <input type="hidden" name="categoryID" value="{{ $categories->id }}">
                            <input id="categoryName" name="categoryName" type="text"
                                class="form-control @error('categoryName') is-invalid @enderror"
                                value="{{ old('categoryName', $categories->name) }}" aria-required="true"
                                aria-invalid="false" placeholder="Seafood...">
                            @error('categoryName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">Update</span>
                                {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                <i class="fa-solid fa-circle-right"></i>
                            </button>
                        </div>
                    </form>
                    {{-- the end of the form --}}




                </div>
            </div>
        </div>
    </div>
@endsection
