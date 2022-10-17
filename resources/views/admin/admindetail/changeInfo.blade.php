@extends('admin.layout.app');
@section('title', 'profile');
@section('content')

    <div class="row">
        <div class="col-10 offset-1">
            <div class="card">
                <div class="card-title pt-3">
                    <h3 class="font-weight-light text-center">My Account Update</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin#updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-5 ">

                                @if (Auth()->user()->image == null)
                                    @if (Auth()->user()->gender == 'male')
                                        <img src="{{ asset('images/icon/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg') }}"
                                            alt="{{ Auth()->user()->name }}" />
                                    @else
                                        <img src="{{ asset('images/icon/360_F_443946416_l2xXrFoIuUkItmyscOK5MNh6h0Vai3Ua.jpg') }}"
                                            alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . Auth()->user()->image) }}"
                                        alt="{{ Auth()->user()->name }}" />
                                @endif

                                <input type="file" name="image" id="" class="form-control"
                                    aria-required="true" aria-invalid="false">

                                <button type="submit" class="btn btn-dark my-4 w-100"><i
                                        class="fa-solid fa-circle-chevron-right mr-3"></i>Update</button>
                            </div>
                            <div class="col-5 offset-1">

                                <label for="name">Name</label>
                                <input type="text" value="{{ old('name', Auth::user()->name) }}" name="name"
                                    id="name"
                                    class="form-control mb-2 @error('name')
                                    is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <label for="name">Gender</label>
                                <select name="gender"
                                    class="form-select form-control mb-2 @error('gender')
                            is-invalid
                            @enderror"
                                    aria-required="true" aria-invalid="false">
                                    <option value="">Choose option</option>
                                    @if (Auth::user()->gender == 'male')
                                        <option value="male" selected>male</option>
                                        <option value="female">female</option>
                                    @else
                                        <option value="male">male</option>
                                        <option value="female" selected>female</option>
                                    @endif

                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="email">Email</label>
                                <input type="email" value="{{ old('email', Auth::user()->email) }}" name="email"
                                    id="email"
                                    class="form-control mb-2
                                @error('email')
                                is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="phone">Phone</label>
                                <input type="number" value="{{ old('phone', Auth::user()->phone) }}" name="phone"
                                    id="phone"
                                    class="form-control mb-2
                                 @error('phone')
                                is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <label for="Address">Address</label>
                                <textarea name="address" id="Address" cols="30" rows="5"
                                    class="form-control mb-2
                                @error('address')
                                    is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="role">Role</label>
                                <input type="text" value="{{ old('name', Auth::user()->role) }}" name="role"
                                    id="role" class="form-control mb-2" aria-required="true" aria-invalid="false"
                                    disabled>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
