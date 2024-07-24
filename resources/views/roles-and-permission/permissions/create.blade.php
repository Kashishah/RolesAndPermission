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
                <form action="{{ route('permissions.store') }}" method="POST" id="permissionForm">
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#permissionForm').validate({
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