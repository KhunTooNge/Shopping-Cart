@extends('user.layout.master')
@section('title', 'MultiShop - Online Shop')
@section('content')
    <div class="row">
        <div class="col-8 offset-2">
            <h1 class="text-center my-2 pb-3">CONNECTING WITH US</h1>
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ route('user#contact#create') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-6">
                        <input type="text" name="name" placeholder="Name...."
                            class="form-control @error('name')
                                is-invalid
                            @enderror"
                            aria-required="true" aria-invalid="false">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="col-6">
                        <input type="email" name="email" placeholder="Email...."
                            class="form-control
                             @error('email')
                                is-invalid
                            @enderror"
                            aria-required="true" aria-invalid="false">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Message </label>
                        <textarea name="message" id="" cols="30" rows="7"
                            class="form-control
                        @error('message')
                            is-invalid
                        @enderror"
                            aria-required="true" aria-invalid="false"></textarea>

                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div>
                    <button type="submit" class="btn btn-info  w-100">Send</button>
                </div>
            </form>


        </div>
    </div>

@endsection
