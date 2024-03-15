@extends('layouts.app', ['activePage' => 'EditUser', 'titlePage' => __('Edit User'), 'namePage' => 'User Update', 'activePage' => 'UpdateUser'])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit User</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('user.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <strong>First Name:</strong>
                    <p>{{ $user->first_name }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Last Name:</strong>
                    <p>{{ $user->last_name }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Role:</strong>
                    @if ($user->hasRole('admin'))
                        <p>Admin</p>
                    @else
                        <p>user</p>
                    @endif
                </div>
            </div>

            @if (auth()->user() && auth()->user()->id != $user->id)
                {{-- Check if the current user is authenticated and is not the user being edited --}}
                {!! Form::open(['method' => 'PATCH', 'route' => ['user.update', $user->id]]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mb-4">Change Role User {{ $user->first_name }} {{ $user->last_name }}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Role:</strong>
                            <p>
                                @if ($user->hasRole('admin'))
                                    User currently has the 'admin' role.

                                @else
                                    User currently does not have any role.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-{{ $user->hasRole('admin') ? 'danger' : 'success' }}">
                                {{ $user->hasRole('admin') ? 'Remove Role' : 'Assign Role as Admin' }}
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            @endif




        </div>
    </div>
@endsection
