@extends('layout.master')
@section('title', 'register')
@section('content')
    <div class="login-form">
        <form action="{{ route('register') }}" method="post">
            @csrf

            @error('terms')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="form-group">
                <label>Username</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Username"
                    value="{{ old('name') }}">

                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email"
                    value="{{ old('email') }}">

                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="au-input au-input--full" type="number" name="phone" placeholder="09.xxxx"
                    value="{{ old('phone') }}">

                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control form-select">
                    <option value="">choose gender</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>

                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


            </div>

            <div class="form-group">
                <label> Address</label>
                <textarea name="address" cols="30" rows="1" class="au-input au-input--full" placeholder="enter address">{{ old('address') }}</textarea>

                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">

                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror


            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input class="au-input au-input--full" type="password" name="password_confirmation"
                    placeholder="Confirm Password">

                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{ route('auth#loginPage') }}">Sign In</a>
            </p>
        </div>
    </div>


@endsection
