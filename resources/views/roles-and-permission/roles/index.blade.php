@extends('layout')

@section('title')
    User Role View
@endsection


@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success mt-5 mb-5">
                {{ session('status') }}
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-header">
                <h3>Roles</h3>
                <div>
                    <div class="float-start">
                        <a href="" class="btn btn-success">User</a>
                        <a href=" {{ route('roles.index') }} " class="btn btn-primary">Roles</a>
                        <a href=" {{ route('permissions.index') }} " class="btn btn-warning">Permission</a>
                    </div>
                    <div class="float-end">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
                       
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SR. No.</th>
                            <th>Name</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($roles)
                            @foreach ($roles as $role)
                                <tr>
                                    <td> {{$role->id}} </td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($permissions as $permission)
                                            <span class="badge text-bg-danger"> {{ $permission->name }} </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href=" {{ route('roles.edit', $role->id) }} " class="btn btn-success">Edit</a>
                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="3" class="text-center"> <strong>No any records</strong> </td>
                        </tr>
                        @endif  

                           
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection