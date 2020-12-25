@extends('layouts.admin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif



    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Agents</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    <div class="card overflow-hidden">
                        <div class="card-body pb-0 px-4 pt-4">
                            <button style="width:100%" type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modal-lg">
                                <i class="lni lni-plus"></i></i> &nbsp Add Agents
                            </button>
                            <br /><br />
                            <div class="table-responsive">
                                <table id="example5" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Change Role</th>
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
                                                <td>
                                                    <select style="width:50px" onchange="location = this.value;"
                                                        class="form-control">
                                                        @if ($user->role == '')
                                                            <option value="" selected>Not Yet Assign</option>
                                                        @endif
                                                        <option value="/manageAgent/admin/{{ $user->id }}" @if ($user->role == 'admin'){ selected }
                                        @endif>Admin</option>
                                        <option value="/manageAgent/shogun/{{ $user->id }}" @if ($user->role == 'shogun'){ selected @endif
                                            }>Shogun
                                        </option>
                                        <option value="/manageAgent/damio/{{ $user->id }}" @if ($user->role == 'damio'){ selected } @endif
                                            >Damio
                                        </option>
                                        <option value="/manageAgent/merchant/{{ $user->id }}" @if ($user->role == 'merchant'){ selected } @endif
                                            >Merchant</option>
                                        <option value="/manageAgent/dropship/{{ $user->id }}" @if ($user->role == 'dropship'){ selected } @endif
                                            >Dropship</option>
                                        </select>
                                        </td>
                                        <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal" onclick="openModalEdit(
                                                                        '{{ $user->id }}',
                                                                        '{{ $user->name }}',
                                                                        '{{ $user->email }}',
                                                                        '{{ $user->phone }}',
                                                                        '{{ $user->address }}',
                                                                        '{{ $user->icnumber }}',
                                                                        '{{ $user->dob }}',
                                                                        '{{ $user->image }}'
                                                                    )" data-target="#modalEdit" class="btn btn-warning"><i
                                                    class="lni lni-pencil-alt"></i></button> &nbsp;
                                            <button type="button" title="View" data-toggle="modal" onclick="openModalView(
                                                                        '{{ $user->id }}',
                                                                        '{{ $user->name }}',
                                                                        '{{ $user->email }}',
                                                                        '{{ $user->phone }}',
                                                                        '{{ $user->address }}',
                                                                        '{{ $user->icnumber }}',
                                                                        '{{ $user->dob }}',
                                                                        '{{ $user->image }}'
                                                                        )" data-target="#modalView"
                                                class="btn btn-success"><i class="lni lni-eye"></i></button> &nbsp;
                                            <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                onclick="window.location.href='manageAgent/delete/{{ $user->id }}'"
                                                class="btn btn-danger"><i class="lni lni-trash"></i></button>
                                            &nbsp;
                                        </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg modal-dialog-centered">
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
                                    <label for="exampleInputFile">Photo <span style="color:yellow">  *</span></label>
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
                                    <label> Name <span style="color:yellow">  *</span></label>
                                    <input type="text" id="name" onkeypress="return isAlphabetsKey(event)" class="form-control"
                                        name="name" placeholder="Name" />
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
                                    <label> IC <span style="color:yellow">  *</span></label>
                                    <input type="text" id="ic" class="form-control" onkeypress="return isNumberKey(event)"
                                        name="ic" placeholder="IC Number" />
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Email <span style="color:yellow">  *</span></label>
                                    <input type="text" id="email" class="form-control" name="email" placeholder="Email" />
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
                                    <label> Date Of Birth <span style="color:yellow">  *</span></label>
                                    <input type="date" id="dob" class="form-control" name="dob"
                                        placeholder="Date Of Birth" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Phone Number <span style="color:yellow">  *</span></label>
                                    <input type="text" id="phoneNum" class="form-control" onkeypress="return isNumberKey(event)" name="phone"
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
                                    <label>Address <span style="color:yellow">  *</span></label>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agent Details</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('manageAgent.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="userID" id="userID" hidden />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">Photo </label>
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
                                    <label> Name <span style="color:yellow">  *</span></label>
                                    <input type="text" id="nameEdit" class="form-control" onkeypress="return isAlphabetsKey(event)" name="nameEdit"
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
                                    <label> IC <span style="color:yellow">  *</span></label>
                                    <input type="text" id="icEdit" class="form-control" onkeypress="return isNumberKey(event)" name="icEdit"
                                        placeholder="IC Number" />
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Email <span style="color:yellow">  *</span></label>
                                    <input type="text" id="emailEdit" class="form-control" name="emailEdit"
                                        placeholder="Email" readonly/>
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
                                    <label> Date Of Birth <span style="color:yellow">  *</span></label>
                                    <input type="date" id="dobEdit" class="form-control" name="dobEdit"
                                        placeholder="Date Of Birth" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Phone Number <span style="color:yellow">  *</span></label>
                                    <input type="text" id="phoneEdit" class="form-control" onkeypress="return isNumberKey(event)" name="phoneEdit"
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
                                    <label>Address <span style="color:yellow">  *</span></label>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
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

@endsection

@section('script')
    <script>
        function isAlphabetsKey(e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z ]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                return false;
            }

            return isValid;
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

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

        function openModalEdit(id, name, email, phone, address, ic, dob, image) {

            document.getElementById("userID").value = id;
            document.getElementById("nameEdit").value = name;
            document.getElementById("emailEdit").value = email;
            document.getElementById("phoneEdit").value = phone;
            document.getElementById("addressEdit").value = address;
            document.getElementById("icEdit").value = ic;
            document.getElementById("dobEdit").value = dob;
            document.getElementById("imageEdit").value = image;

        }

        function openModalView(id, name, email, phone, address, ic, dob, image) {

            document.getElementById('viewEmpName').innerText = name;

            if(image != ''){
            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<img style='display: block; margin-left: auto; margin-right: auto;' width='150px' height='150px' src='../imageUploaded/profile/" +
                image + "'/>" +
                "</div>" +
                "<div class='col-sm-6'>" +
                "<b>Name  </b>" + "<br/>" + name + "<br/>" +
                "<b>Email  </b>" + "<br/>" + email + "<br/>" +
                "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
                "<b>IC Number </b>" + "<br/>" + ic + "<br/>" +
                "<b>Address  </b>" + "<br/>" + address + "<br/>" +
                "</div>" +
                "</div>";

            }else{
                document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<span>No Photo</span>" +
                "</div>" +
                "<div class='col-sm-6'>" +
                "<b>Name  </b>" + "<br/>" + name + "<br/>" +
                "<b>Email  </b>" + "<br/>" + email + "<br/>" +
                "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
                "<b>IC Number </b>" + "<br/>" + ic + "<br/>" +
                "<b>Address  </b>" + "<br/>" + address + "<br/>" +
                "</div>" +
                "</div>";
            }
        }

    </script>
@endsection
