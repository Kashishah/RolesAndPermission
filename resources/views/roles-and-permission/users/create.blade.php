@extends('layout')

@section('title')
    User Create
@endsection


@section('content')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="">User</h3>
            </div>
                
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" id="userForm">
                    @csrf

                    <div class="mb-3">
                        <label for="">User Name</label>
                        <input name="name" type="text" class="form-control">
                        @error('name')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="">Email</label>
                        <input name="email" type="text" class="form-control">
                        @error('email')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="">Password</label>
                        <input name="password" type="text" class="form-control">
                        @error('password')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="">Roles</label>
                        <select name="roles[]" class="form-control" id="" multiple>
                            <option value="" selected disabled>Select Roles</option>
                            @foreach ($roles as $role )
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        
                        @error('roles')
                            <div class="text text-danger"> {{ $message }} </div>
                        @enderror
                    </div>

                    <div class="submit">
                        <input type="submit" value="Create a Role" class="btn btn-success">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#userForm').validate({
                rules: {
                    'name': {
                        required: true
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'password': {
                        required : true ,
                        // minlength: 8,
                        // minlength: 20
                    },
                    'roles[]' : {
                        required: true,
                    }
                },
                messages: {
                    'name': {
                        required: "Please enter your name"
                    },
                    'email': {
                        required: 'Please enter a email',
                        email: 'Email format is wrong'
                    },
                    'password': {
                        required : 'Please enter a password' ,
                        // minlength: 'Minimum length is 8',
                        // maxlength: 'Maximum length is 20'
                    },
                    'roles[]' : {
                        required: 'Select atleast any 1 option',
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection