@extends('layout')

@section('title')
    User Permission Create
@endsection


@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <div class="float-start">
                <h3 class="">User Permission</h3>
                </div>
                
                <div class="float-end">
                    <a href="" class="btn btn-success">User</a>
                    <a href="" class="btn btn-primary">Roles</a>
                    <a href="" class="btn btn-warning">Permission</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control">
                        @error('name')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="submit">
                        <input type="submit" value="Create a Permission" class="btn btn-success">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection