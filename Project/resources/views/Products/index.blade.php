@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'Products',
])

@section('content')
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
        {{-- show notification --}}
        {{-- @push('js') --}}
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
        {{-- @endpush --}}


        <div class="row">
            <div class="col-md-12">
                <div class="card mt-6">
                    <div class="card-header">
                        <h4 class="card-title">Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <a  href="{{ route('products.create') }}" class="btn btn-primary btn-round text-white pull-right">
                                Create New</a>
                        </div>
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span class="avatar avatar-sm rounded-circle">
                                                <img src="{{asset($product->image) }}" alt="{{ $product->name }}"
                                                    style="max-width: 800px; max-height: 150px; border-radius: 10px">
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a type="button" href="{{ route('products.show', $product->id) }}"
                                                rel="tooltip" class="btn btn-success btn-icon btn-sm "
                                                data-original-title="" title="">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </a>
                                            <a type="button" href="{{ route('products.show', $product->id) }}"
                                                rel="tooltip" class="btn btn-success btn-icon btn-sm "
                                                data-original-title="" title="">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this Product {{$product->name}}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination Links --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{$products->links("pagination::bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
