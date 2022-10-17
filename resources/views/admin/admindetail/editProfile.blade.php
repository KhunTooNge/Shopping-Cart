@extends('admin.layout.app');
@section('title', 'profile');
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 offset-1 shadow">
                <div class="card" style="background: inherit;border:none;outline:none;">
                    <div class="card-title py-3">
                        <h2 class="font-weight-light text-center">Account Info</h2>
                    </div>
                    <div class="card-body">
                        <div class="row gap-2">
                            <div class="col-5 ">
                                @if (Auth()->user()->image == null)
                                    @if (Auth()->user()->gender == 'female')
                                        <img src="{{ asset('images/icon/360_F_443946416_l2xXrFoIuUkItmyscOK5MNh6h0Vai3Ua.jpg') }}"
                                            alt="">
                                    @else
                                        <img src="{{ asset('images/icon/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg') }}"
                                            alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . Auth()->user()->image) }}" alt="John Doe" />
                                @endif

                                <a href="{{ route('admin#editProfile') }}" class="d-flex justify-content-center">
                                    <button class="btn  btn-dark mt-3 rounded-pill"><i
                                            class="fa-solid fa-pen-to-square pr-3"></i>Edit Profile</button>
                                </a>
                            </div>
                            <div class="col-5 offset-1 " style="font-size: 1.2rem;cursor: help;">
                                <p class="mb-3 "><i class="fa-solid fa-user-pen pe-2"></i> {{ $user->name }} </p>
                                <p class="mb-3 "><i class="fa-regular fa-envelope pe-3"></i>{{ $user->email }}</p>
                                <p class="mb-3 "><i class="fa-solid fa-phone-flip pe-2"></i> {{ $user->phone }}</p>
                                <p class="mb-3 "><i class="fa-solid fa-transgender pe-3"></i>{{ $user->gender }}</p>
                                <p class="mb-3 "><i class="fa-solid fa-address-card pe-3"></i>{{ $user->address }}</p>
                                <p class="mb-3 "><i class="fa-solid fa-user-clock pe-2"></i>
                                    {{ $user->updated_at->format('j F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
