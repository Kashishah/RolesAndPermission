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
            <form action="{{ route('roles.store') }}" method="POST" id="roleForm">
                @csrf

                <div class="mb-3">
                    <label for="roleName">Name</label>
                    <input id="roleName" name="name" type="text" class="form-control">
                    <div id="error-message-rolename" class="text-danger"></div> <!-- jQuery validation error message -->
                    @error('name')
                    <div class="text-danger">{{ $message }}</div> <!-- Laravel server-side validation error message -->
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Permissions</label>
                    @foreach ($permissions as $permission)
                    <div>
                        <input type="checkbox" id="{{ $permission }}" name="permissions[]" value="{{ $permission }}">
                        <label for="{{ $permission }}">{{ $permission }}</label>
                    </div>
                    @endforeach
                    <div id="error-message-permissions" class="text-danger"></div> <!-- jQuery validation error message -->
                    @error('permissions')
                    <div class="text-danger">{{ $message }}</div> <!-- Laravel server-side validation error message -->
                    @enderror
                </div>

                <div class="submit">
                    <input id="submitbtn" type="submit" value="Create a Role" class="btn btn-success">
                </div>
            </form>


        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

        $('#roleName').on('blur', function() {
            var rolename = $(this).val().trim();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(rolename);
            if (!rolename) {
                $('#error-message-rolename').text('Please fill the value'); // Update text if roleName is empty
                return;
            } else {
                $.ajax({
                    dataType: 'json',
                    type: 'GET',
                    url: "{{route('check_role')}}",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    data: {
                        roleName: rolename
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#error-message-rolename').text('Role name already exist in our data');
                        } else {
                            $('#error-message-rolename').text(''); // Clear error message if roleName is valid
                        }

                    }
                });
            }
        });

        // $('#submitbtn').on('click', function() {
        //     var isChecked = $('input[name="permissions[]"]:checked').length > 0;
        //     if (!isChecked) {
        //     $('#error-message-permissions').text('Please select at least one permission');
        //     // return; // Exit function if no checkbox is checked
        // } else {
        //     $('#error-message-permissions').text(''); // Clear error message if checkboxes are checked 
        // }
        // });
        $('#roleForm').validate({
            rules: {
                'name': {
                    required: true,
                },
                'permissions[]': {
                    required: true,
                    minlength: 1 // Ensure at least one checkbox is checked
                }
            },
            messages: {
                'name': {
                    required: "Please enter a role name"
                },
                'permissions[]': {
                    required: "Please select at least one permission",
                    minlength: "Please select at least one permission" // Custom message for minlength rule
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "permissions[]") {
                    error.appendTo("#error-message-permissions"); // Append error message to specific div for permissions
                } else {
                    error.appendTo("#error-message-rolename"); // Append error message to specific div for role name
                }
            }
        });
    });
</script>
@endsection