@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'Products',
])

@section('content')
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-6">
                    <div class="card-header">
                        <h4 class="card-title">Craete New Product</h4>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            create new Product
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
