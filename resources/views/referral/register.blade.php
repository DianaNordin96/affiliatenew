<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register Page</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h3 style="text-align: center">Affiliate System</h3>
                                    <h4 style="text-align: center">REGISTER AS DOWNLINE</h4>

                                    <form action="{{ url('registerDownline') }} " method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" name="id" value="{{ $userID }}" hidden />
                                        <div class="row">
                                            {{-- @if (Session::get('failed') != null)
                                                <a style="text-decoration: none;color:red">{{ Session::get('failed') }}</a>
                                            @endif --}}
                                            <div class="col-12">
                                                Name <br />
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Full name">
                                            </div>
                                            <br /><br />

                                            <div class="col-12">
                                                IC Number <br />
                                                <input type="text" class="form-control" name="ic"
                                                    placeholder="IC Number">
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

                                            @if (Session::get('error') != null)
                                                {
                                                <a
                                                    style="text-decoration: none;color:red">{{ Session::get('error') }}</a>
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
                                                <button type="submit"
                                                    class="btn btn-primary btn-block">Register</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>
                                </div>
                                <!-- /.form-box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
         @if (Session::get('failed') != null)
        // toastr.success("{{ Session::get('success') }}");
        Swal.fire(
        'Error',
        "{{ Session::get('failed') }}",
        'error'
        )
        @endif
        </script>
</body>

</html>
