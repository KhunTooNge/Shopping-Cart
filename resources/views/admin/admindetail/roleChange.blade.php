@extends('admin.layout.app');
@section('title', 'profile');
@section('content')

    <div class="row">
        <div class="col-10 offset-1">
            <a href="{{ route('admin#list') }}">
                <button class="btn btn-dark mb-3">List</button>
            </a>
            <div class="card">
                <div class="card-title pt-3">
                    <h3 class="font-weight-light text-center">Role Change</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin#roleChange', $account->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-5 ">


                                @if ($account->image == null)
                                    @if ($account->gender == 'male')
                                        <img src="{{ asset('images/icon/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg') }}"
                                            alt="{{ $account->name }}" />
                                    @else
                                        <img src="{{ asset('images/icon/360_F_443946416_l2xXrFoIuUkItmyscOK5MNh6h0Vai3Ua.jpg') }}"
                                            alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . $account->image) }}" alt="{{ $account->name }}" />
                                @endif

                                <input type="file" name="image" id="" class="form-control"
                                    aria-required="true" aria-invalid="false" disabled>

                                <button type="submit" class="btn btn-dark my-4 w-100"><i
                                        class="fa-solid fa-circle-chevron-right mr-3"></i>Change Role</button>
                            </div>
                            <div class="col-5 offset-1">

                                <label for="name">Name</label>
                                <input type="text" value="{{ old('name', $account->name) }}" name="name"
                                    id="name"
                                    class="form-control mb-2 @error('name')
                                    is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false" disabled>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="role">Role</label>
                                <select name="role"
                                    class="form-select form-control mb-2 @error('role')
                            is-invalid
                            @enderror"
                                    aria-required="true" aria-invalid="false">
                                    <option value="admin" @if ($account->role == 'admin') selected @endif>admin</option>
                                    <option value="user" @if ($account->role == 'user') selected @endif>user</option>
                                </select>


                                <label for="name">Gender</label>
                                <select name="gender"
                                    class="form-select form-control mb-2 @error('gender')
                            is-invalid
                            @enderror"
                                    aria-required="true" aria-invalid="false" disabled>
                                    <option value="">Choose option</option>

                                    @if ($account->gender == 'male')
                                        <option value="male" selected>male</option>
                                        <option value="female">female</option>
                                    @elseif ($account->gender == 'female')
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
                                <input type="email" value="{{ old('email', $account->email) }}" name="email"
                                    id="email"
                                    class="form-control mb-2
                                @error('email')
                                is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false" disabled>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="phone">Phone</label>
                                <input type="number" value="{{ old('phone', $account->phone) }}" name="phone"
                                    id="phone"
                                    class="form-control mb-2
                                 @error('phone')
                                is-invalid
                                @enderror"
                                    aria-required="true" aria-invalid="false" disabled>
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
                                    aria-required="true" aria-invalid="false" disabled>{{ old('address', $account->address) }}</textarea>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
