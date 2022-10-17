@extends('admin.layout.app')
@section('title', 'change password')
@section('content')
    <div class="container-fluid">
        <div class="col-lg-7 offset-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Change Password</h3>
                    </div>
                    <hr>
                    {{-- @if (Session::has('message'))
                        <div class="alert alert-danger">{{ Session::get('message') }}</div>
                    @endif --}}
                    {{-- form change password --}}
                    <form action="{{ route('admin#updatePassword') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="oldPass" class="control-label mb-1">Old Password</label>
                            <input id="oldPass" name="oldPass" type="password"
                                class="form-control
                                @if (session('err')) is-invalid @endif
                                @error('oldPass') is-invalid @enderror"
                                aria-required="true" aria-invalid="false">
                            @error('oldPass')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if (session('err'))
                                <div class="invalid-feedback">{{ session('err') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="newPass" class="control-label mb-1">New Password</label>
                            <input id="newPass" name="newPass" type="password"
                                class="form-control @error('newPass') is-invalid @enderror" aria-required="true"
                                aria-invalid="false">
                            @error('newPass')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirmPass" class="control-label mb-1">Confirm Password</label>
                            <input id="confirmPass" name="confirmPass" type="password"
                                class="form-control @error('confirmPass') is-invalid @enderror" aria-required="true"
                                aria-invalid="false">
                            @error('confirmPass')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">

                                {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                <i class="fa fa-key mr-2"></i>
                                <span id="payment-button-amount">Change Password</span>

                            </button>
                        </div>
                    </form>
                    {{-- the end of the form --}}
                </div>
            </div>
        </div>
    </div>

@endsection
