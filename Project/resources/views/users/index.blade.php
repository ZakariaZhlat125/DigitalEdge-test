@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'User Profile',
    'activePage' => 'users',
    'activeNav' => '',
])

@section('content')
    <!-- End Navbar -->
    <div class="panel-header">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary btn-round text-white pull-right" href="#">Add user</a>
                        <h4 class="card-title">Users</h4>
                        <div class="col-12 mt-2">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Creation date</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <span class="avatar avatar-sm rounded-circle">
                                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt=""
                                                    style="max-width: 80px; border-radiu: 100px">
                                            </span>
                                        </td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if ($user->hasRole('admin'))
                                            <td>Admin</td>
                                        @else
                                            <td>user</td>
                                        @endif
                                        <td>{{ $user->created_at }}</td>
                                        <td class="text-right">
                                            <a type="button" href="{{ route('user.edit', $user->id) }}" rel="tooltip"
                                                class="btn btn-success btn-icon btn-sm " data-original-title=""
                                                title="">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </a>
                                            @if (auth()->user() != $user)
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-icon btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this sub category?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <div class="alert alert-danger">
            <span>
                <b></b> This is a PRO feature!</span>
        </div>
        <!-- end row -->
    </div>
@endsection
