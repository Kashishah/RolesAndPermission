@extends('layout')

@section('title')
    User Role Create
@endsection


@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <div class="float-start">
                <h3 class="">User Role</h3>
                </div>
                
                <div class="float-end">
                    <a href="" class="btn btn-success">User</a>
                    <a href="" class="btn btn-primary">Roles</a>
                    <a href="" class="btn btn-warning">Permission</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control">
                        @error('name')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="">Permissions</label>
                    @foreach ($permissions as $permission)
                        <div>
                            <input type="checkbox"
                                id="{{ $permission }}"
                                name="permissions[]"
                                value="{{ $permission }}">
                            <label for="{{ $permission }}">{{ $permission }}</label>
                        </div>
                    @endforeach
                       
                    </div>

                    <div class="submit">
                        <input type="submit" value="Create a Role" class="btn btn-success">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection