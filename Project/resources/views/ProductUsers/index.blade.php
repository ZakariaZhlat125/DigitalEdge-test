@extends('layouts.app', [
    'namePage' => 'ProductsUser',
    'class' => 'sidebar-mini',
    'activePage' => 'ProductsUser',
])

@section('content')
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
        {{-- show notification --}}
        @push('js')
            @if (session('success'))
                <script>
                    nowuiDashboard.showNotification('top', 'right', '{{ session('success') }}', 'success');
                </script>
            @endif

            @if (session('error'))
                <script>
                    nowuiDashboard.showNotification('top', 'right', '{{ session('error') }}', 'danger');
                </script>
            @endif
        @endpush

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-6">
                        <div class="card-header">
                            <h4 class="card-title">Assigned Products to Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <a href="{{ route('productsUser.assign') }}"
                                    class="btn btn-primary btn-round text-white pull-right">
                                    Assign Product</a>
                            </div>
                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Products name </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usersWithProducts as $user)
                                        @if ($user->products->isNotEmpty())
                                            @foreach ($user->products as $product)
                                                <tr>
                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td class="text-right">
                                                        <form action="{{ route('productsUser.unassignProductFromUser') }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product->id }}">
                                                            <button type="submit" class="btn btn-danger btn-icon btn-sm"
                                                                onclick="return confirm('Are you sure you want to unassign this product from the user?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $user->first_name }} {{ $user->last_name }} </td>
                                                <td colspan="3">No Products assigned to this user.</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination Links --}}
                            <div class="d-flex justify-content-center mt-4">
                                {{ $usersWithProducts->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
