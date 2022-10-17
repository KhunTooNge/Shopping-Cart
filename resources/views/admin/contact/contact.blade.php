@extends('admin.layout.app')
@section('title', 'Contact List')
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


                        <form class="form-header" action="{{ route('admin#contact') }}" method="GET">
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
                    <i class="fa fa-database mx-2"></i> {{ $contact->total() }}
                </div>
            </div>

            <div class="table-responsive table-responsive-data2">
                @if (count($contact) != 0)
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($contact as $item)
                                <tr class="tr-shadow">
                                    <td class="align-middle" id="mainId">{{ $item->id }}</td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->email }} </td>
                                    <td> {{ $item->message }} </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                    <div>
                        {{ $contact->links() }}
                    </div>
                @else
                    <h3 class="text-muted text-center mt-5">There is no Data</h3>
                @endif
            </div>
            <!-- END DATA TABLE -->
        </div>
    </div>

@endsection
@section('scriptSection')
    <script>
        $(document).ready(function() {
            $('.roleChange').change(function() {
                $role = $(this).val();
                $parentNodes = $(this).parents('tr');
                $id = $parentNodes.find('#mainId').text();
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/customer/roleChange',
                    data: {
                        id: $id,
                        role: $role,
                    },
                    dataType: 'json',
                    success: location.reload()
                })
            })
        })
    </script>
@endsection
