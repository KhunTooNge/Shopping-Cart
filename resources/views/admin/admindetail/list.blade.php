@extends('admin.layout.app')
@section('title', 'Admin List')
@section('content')

    <div class="container-fluid">
        <div class="col-md-12">
            <!-- DATA TABLE -->
            <div class="row align-items-center">
                <div class="col-3">
                    <h5 class="text-secondary">Search Keys : <span class=" text-danger">{{ request('keys') }}</span></h5>
                </div>
                <div class="col-5">

                </div>
                <div class="col-4">
                    <div class="header-wrap">


                        <form class="form-header" action="{{ route('admin#list') }}" method="GET">
                            @csrf
                            <input class="au-input" type="text" name="keys" placeholder="Search for datas" />
                            <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>


                    </div>
                </div>
            </div>



            <div class="row my-2">
                <div class="col-9">
                    @if (Session::has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col-1 offset-1 bg-white shadow-sm p-2 text-center">
                    <i class="fa fa-database mx-2"></i> {{ $admin->total() }}
                </div>
            </div>

            <div class="table-responsive table-responsive-data2">
                @if (count($admin) != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($admin as $item)
                                <tr class="tr-shadow">
                                    <td>
                                        @if ($item->image == null)
                                            @if ($item->gender == 'female')
                                                <img src="{{ asset('images/icon/360_F_443946416_l2xXrFoIuUkItmyscOK5MNh6h0Vai3Ua.jpg') }}"
                                                    alt="" width="120px">
                                            @else
                                                <img src="{{ asset('images/icon/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg') }}"
                                                    alt="" width="120px">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="" width="120px">
                                        @endif
                                    </td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->email }} </td>
                                    <td> {{ $item->phone }} </td>
                                    <td> {{ $item->address }} </td>
                                    <td> {{ $item->gender }} </td>
                                    <td>
                                        <div class="table-data-feature">

                                            @if (Auth::user()->id == $item->id)
                                            @else
                                                <a href="{{ route('admin#userDelete', $item->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="role change">
                                                        <i class="zmdi zmdi-delete"></i>

                                                    </button>
                                                </a>
                                                <a href="{{ route('admin#role', $item->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="role change">
                                                        <i class="fa-solid fa-people-carry-box"></i>
                                                    </button>
                                                </a>
                                            @endif


                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                    <div>
                        {{ $admin->links() }}
                    </div>
                @else
                    <h3 class="text-muted text-center mt-5">There is no Data</h3>
                @endif
            </div>
            <!-- END DATA TABLE -->
        </div>
    </div>

@endsection
