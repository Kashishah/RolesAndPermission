@extends('layout')

@section('title')
    Users
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
                <h3>Users</h3>
                <div>
                @if(auth()->user()->can('See Buttons Permission') )
                    <div class="float-start">
                        <a href="{{ route('users.index') }}" class="btn btn-success">User</a>
                        <a href=" {{ route('roles.index') }} " class="btn btn-primary">Roles</a>
                        <a href=" {{ route('permissions.index') }} " class="btn btn-warning">Permission</a>
                    </div>
                @endif
                @if(auth()->user()->can('See Buttons Permission') )
                    <div class="float-end">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
                    </div>
                @endif

                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    {{ $users->links() }}
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SR. No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users)
                            @foreach ($users as $user)
                                <tr>
                                    <td> {{$user->id}} </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="d-flex flex-wrap">
                                        <!-- this getRoleNames() fetch the roles according users it is the function of SPATIE -->
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $roleName)
                                            <label for="" class="me-1 badge badge-pill text-bg-dark">{{$roleName}}</label>
                                        @endforeach
                                        
                                    @endif
                                    </td>
                                    <td>
                                        <a href=" {{ route('users.edit', $user->id) }} " class=" mb-1 btn btn-success">Edit</a>
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mb-1 btn btn-danger">Delete</button>
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