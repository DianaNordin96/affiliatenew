@extends('layouts.dropship')


@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Profile</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Consignment</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Update Profile</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('profileDropship-update') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="name" class="form-control" name="name"
                                    value="{{ Auth::user()->name }}" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone Number</label>
                                <input type="name" class="form-control" name="phone"
                                    value="{{ Auth::user()->phone }}" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                    value="{{ Auth::user()->email }}" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" id="address" rows="3"
                                    placeholder="Address">{{ Auth::user()->address }}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save data</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('change-password-dropship') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" minlength="8" class="form-control" name="password1"
                                    placeholder="Enter New Password">
                            </div>
                            <div class="form-group">
                                <label>Re-enter Password</label>
                                <input type="password" minlength="8" class="form-control" name="password2"
                                    placeholder="Re-enter Password">
                            </div>
                        <br/>
                            <button type="submit" class="btn btn-primary">Change Password</button>


                            <br/><br/><br/><br/>

                            <h3>Referral Link</h3>
                            <div class="form-group">
                                <input style="width:200px" type="text"
                                    value="http://tryitgo.com/registerDownline/{{ Auth::user()->id }}" id="link"
                                    readonly>
                                <button class="btn btn-primary" onclick="myFunction()">Copy text</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    
    </div>
</div>


@endsection

@section('script')
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("link");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */

        alert("Copied the text: " + copyText.value);
    }

</script>
@endsection
