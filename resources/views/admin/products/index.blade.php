@extends('admin.layout.app')
@section('title', 'Product List')
@section('content')

    <div class="container-fluid">
        <div class="col-md-12">
            <!-- DATA TABLE -->
            <div class="row align-items-center">
                <div class="col-4">
                    <a href="{{ route('product#add') }}">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>Add Product
                        </button>
                    </a>
                </div>
                <div class="col-3">
                    <h5 class="text-secondary">Search Keys : <span class=" text-danger">{{ request('keys') }}</span></h5>
                </div>
                <div class="col-1 bg-white shadow-sm p-2 text-center">
                    <i class="fa fa-database mx-2"></i> {{ $product->total() }}
                </div>
                <div class="col-4">
                    <div class="header-wrap">


                        <form class="form-header" action="{{ route('product#list') }}" method="GET">
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
                <div class="col-12">
                    @if (Session::has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

            </div>

            <div class="table-responsive table-responsive-data2">
                @if (count($product) != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>View Count</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($product as $item)
                                <tr class="tr-shadow">
                                    <td>
                                        <img src="{{ asset('storage/' . $item->image) }}" width="120" class="shadow-sm">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span class="block-email">{{ $item->price }}</span>
                                    </td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->view_count }}</td>
                                    <td>
                                        <div class="table-data-feature">

                                            <a href="{{ route('product#detail', $item->id) }}">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="View">
                                                    <i class="zmdi zmdi-eye"></i>
                                                </button>
                                            </a>


                                            <a href="{{ route('product#edit', $item->id) }}">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                            </a>


                                            <a href="{{ route('product#delete', $item->id) }}">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @empty
                            @endforelse



                        </tbody>
                    </table>
                    <div>
                        {{ $product->links() }}
                    </div>
                @else
                    <h3 class="text-muted text-center mt-5">There is no Data</h3>
                @endif
            </div>
            <!-- END DATA TABLE -->
        </div>
    </div>

@endsection
