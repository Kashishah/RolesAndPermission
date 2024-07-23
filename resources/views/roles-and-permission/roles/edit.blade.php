@extends('layout')

@section('title')
    User Role Create
@endsection


@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="">User Role</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.update',$role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ $role->name }}">
                        @error('name')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="submit">
                        <input type="submit" value="Update" class="btn btn-success">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection