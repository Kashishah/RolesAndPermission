@extends('layout')

@section('title')
    User Permission Edit
@endsection


@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="">User Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.update',$permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ $permission->name }}">
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