@extends('layouts.app', ['activePage' => 'EditCategory', 'titlePage' => __('Edit Category'), 'namePage' => 'Category Update', 'activePage' => 'UpdateCategory'])

@section('content')
    <div class="panel-header panel-header-sm"></div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ $product->name }}</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <strong>Name:</strong>
                    <p>{{ $product->name }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Image:</strong>
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <strong>Description :</strong>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
            <div id="editForm">
                {!! Form::model($product, [
                    'method' => 'PUT',
                    'route' => ['products.update', $product->id],
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <strong>Image</strong>
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
                        style="display: none; max-width: 800px; max-height: 150px; margin-top: 10px; border-radius: 10px">
                    <img id="preview" src="#" alt="your image" class="mt-3" style="display:none;" />

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
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button id="editCategory" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#editForm').hide();
                $("#editCategory").click(function(e) {
                    e.preventDefault();
                    $('#editForm').toggle();
                    $('#editCategory').hide();
                });
            });
        </script>
    @endpush
@endsection
