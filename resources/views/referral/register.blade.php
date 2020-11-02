<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>Affiliate</b>System</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">REGISTER AS DOWNLINE {{ $userID }}</p>

                <form action="{{ url('registerDownline') }} " method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="id" value="{{ $userID }}" hidden />
                    <div class="row">
                        @if (Session::get('failed') != null)
                            <a style="text-decoration: none;color:red">{{ Session::get('failed') }}</a>

                        @endif
                        <div class="col-12">
                            Name <br />
                            <input type="text" class="form-control" name="name" placeholder="Full name">
                        </div>
                        <br /><br />

                        <div class="col-12">
                            IC Number <br />
                            <input type="text" class="form-control" name="ic" placeholder="IC Number">
                        </div>
                        <br /><br />

                        <div class="col-12">
                            Date Of Birth <br />
                            <input type="date" class="form-control" name="dob">
                        </div>
                        <br /><br />

                        <div class="col-12">
                            Phone Number <br />
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <br /><br />

                        <div class="col-12">
                            Address <br />
                            <textarea class="form-control" name="address" id="address" rows="3"
                                placeholder="Address"></textarea>
                        </div>
                        <br /><br />

                        <div class="col-12">
                            Email <br />
                            <input type="email" class="form-control" name="email">
                        </div>
                        <br /><br />

                        {{-- <div class="col-12">
                            Password <br />
                            <input type="password" class="form-control" name="password1">
                        </div>
                        <br /><br />

                        <div class="col-12">
                            Re-enter Password <br />
                            <input type="password" class="form-control" name="password2">
                        </div>
                        <br /><br /> --}}

                        @if (Session::get('error') != null){
                            <a style="text-decoration: none;color:red">{{ Session::get('error') }}</a>
                            }
                        @endif

                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image">
                                        <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
