@extends('layouts.app', [
    'namePage' => 'Products',
    'class' => 'sidebar-mini',
    'activePage' => 'Products',
])

@section('content')
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
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-6">
                    <div class="card-header">
                        <h4 class="card-title">Create New Product</h4>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="card-body">
                        {!! Form::open([
                            'method' => 'POST',
                            'route' => ['products.store'],
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Image :</strong>
                                    <div class="custom-file">
                                        {!! Form::file('image', [
                                            'class' => 'custom-file-input',
                                            'id' => 'customFile',
                                            'onchange' => "readURL(this, 'imagePreview', 'customFileLabel')",
                                        ]) !!}
                                        <label class="custom-file-label" id="customFileLabel" for="customFile">Choose
                                            file</label>
                                    </div>
                                    <img id="imagePreview" src="#" alt="Image Preview"
                                        style="display: none; max-width: 100%; margin-top: 10px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {!! Form::textarea('description', null, [
                                        'placeholder' => 'Description',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Product', ['class' => 'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
