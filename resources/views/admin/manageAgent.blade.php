@extends('layouts.admin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manage User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                    data-target="#modal-lg">
                                    <i class="fas fa-plus"></i> &nbsp Add Agents
                                </button>
                                <br />
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                        onclick="openModalEdit(
                                                            '{{ $user->id }}',
                                                            '{{ $user->name }}',
                                                            '{{ $user->email }}',
                                                            '{{ $user->phone }}',
                                                            '{{ $user->address }}',
                                                            '{{ $user->icnumber }}',
                                                            '{{ $user->dob }}',
                                                            '{{ $user->image }}'
                                                        )"
                                                        data-target="#modalEdit" class="btn btn-warning"><i
                                                            class="fas fa-edit"></i></button> &nbsp;
                                                    <button type="button" title="View" data-toggle="modal"
                                                        onclick="openModalView(
                                                            '{{ $user->id }}',
                                                            '{{ $user->name }}',
                                                            '{{ $user->email }}',
                                                            '{{ $user->phone }}',
                                                            '{{ $user->address }}',
                                                            '{{ $user->icnumber }}',
                                                            '{{ $user->dob }}',
                                                            '{{ $user->image }}'
                                                            )"
                                                        data-target="#modalView" class="btn btn-success"><i
                                                            class="far fa-eye"></i></button> &nbsp;
                                                    <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                        onclick="window.location.href='manageAgent/delete/{{ $user->id }}'"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
                                                    &nbsp;
                                                    <select onchange="location = this.value;" class="btn btn-default">
                                                        @if($user->role == '')
                                                        <option value="" selected >Not Yet Assign</option>
                                                        @endif
                                                        <option value="/manageAgent/admin/{{ $user->id }}" @if ($user->role == 'admin'){ selected }
                                        @endif>Admin</option>
                                        <option value="/manageAgent/shogun/{{ $user->id }}" @if ($user->role == 'shogun'){ selected @endif}>Shogun
                                        </option>
                                        <option value="/manageAgent/damio/{{ $user->id }}" @if ($user->role == 'damio'){ selected } @endif>Damio
                                        </option>
                                        <option value="/manageAgent/merchant/{{ $user->id }}" @if ($user->role == 'merchant'){ selected } @endif
                                            >Merchant</option>
                                        <option value="/manageAgent/dropship/{{ $user->id }}" @if ($user->role == 'dropship'){ selected } @endif
                                            >Dropship</option>
                                        </select>
                                        </td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.container-fluid -->

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('manageAgent.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
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
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Name </label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" />
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> IC </label>
                                            <input type="text" id="ic" class="form-control" name="ic"
                                                placeholder="IC Number" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" id="email" class="form-control" name="email"
                                                placeholder="Email" />
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Date Of Birth </label>
                                            <input type="date" id="dob" class="form-control" name="dob"
                                                placeholder="Date Of Birth" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Phone Number </label>
                                            <input type="text" id="phoneNum" class="form-control" name="phone"
                                                placeholder="Phone Number" />
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" id="address" rows="3"
                                                placeholder="Address"></textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Agent</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

            <div class="modal fade" id="modalEdit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Employee Details</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('manageAgent.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="userID" id="userID" hidden/>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" id="imageEdit" name="imageEdit">
                                                    <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Name </label>
                                            <input type="text" id="nameEdit" class="form-control" name="nameEdit"
                                                placeholder="Name" />
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> IC </label>
                                            <input type="text" id="icEdit" class="form-control" name="icEdit"
                                                placeholder="IC Number" />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" id="emailEdit" class="form-control" name="emailEdit"
                                                placeholder="Email" />
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Date Of Birth </label>
                                            <input type="date" id="dobEdit" class="form-control" name="dobEdit"
                                                placeholder="Date Of Birth" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Phone Number </label>
                                            <input type="text" id="phoneEdit" class="form-control" name="phoneEdit"
                                                placeholder="Phone Number" />
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="addressEdit" id="addressEdit" rows="3"
                                                placeholder="Address"></textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>


                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

            <div class="modal fade" id="modalView">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="viewEmpName"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-body-view">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        document.getElementById("agents").className = "nav-link active";

        function openModalEdit(id, name, email, phone, address, ic, dob,image) {

            document.getElementById("userID").value = id;
            document.getElementById("nameEdit").value = name;
            document.getElementById("emailEdit").value = email;
            document.getElementById("phoneEdit").value = phone;
            document.getElementById("addressEdit").value = address;
            document.getElementById("icEdit").value = ic;
            document.getElementById("dobEdit").value = dob;

        }

        function openModalView(id, name, email, phone, address,ic, dob,image) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<img style='display: block; margin-left: auto; margin-right: auto;' width='150px' height='150px' src='../imageUploaded/profile/"+ image +"'/>"+
                "</div>"+
                "<div class='col-sm-6'>" +
                "<b>Name  </b>" + "<br/>" + name + "<br/>" +
                "<b>Email  </b>" + "<br/>" + email + "<br/>" +
                "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
                "<b>IC Number </b>" + "<br/>" + ic + "<br/>" +
                "<b>Address  </b>" + "<br/>" + address + "<br/>" +
                "</div>"+
                "</div>";
        }

    </script>
@endsection
