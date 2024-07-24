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
                <form action="{{ route('permissions.update',$permission->id) }}" method="POST"  id="permissionEditForm">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#permissionEditForm').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection