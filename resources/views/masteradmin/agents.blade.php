@extends('layouts.masteradmin')
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
                    <div class="card">
                        <div class="card-body">
                            <button style="width:100%" type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modal-lg">
                            <i class="lni lni-plus"></i></i> &nbsp Add Agents
                        </button><br/><br/>
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
                                            <th>View Profile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agentList as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @if($user->role == 'shogun')
                                                        Shogun
                                                    @elseif($user->role != '')    
                                                    <select style="width:50px" onchange="location = this.value;"
                                                        class="form-control">
                                                        <option value="/master-manageAgent/shogun/{{ $user->id }}" @if ($user->role == 'shogun'){ selected } @endif >Shogun</option>
                                                        <option value="/master-manageAgent/damio/{{ $user->id }}" @if ($user->role == 'damio'){ selected } @endif >Damio</option>
                                                        <option value="/master-manageAgent/merchant/{{ $user->id }}" @if ($user->role == 'merchant'){ selected } @endif>Merchant</option>
                                                        <option value="/master-manageAgent/dropship/{{ $user->id }}" @if ($user->role == 'dropship'){ selected } @endif>Dropship</option>
                                                    </select>
                                                    @endif
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
                                                onclick="window.location.href='master-manageAgent/delete/{{ $user->id }}'"
                                                class="btn btn-danger"><i class="lni lni-trash"></i></button>
                                        </td>
                                        <td>
                                            <a href="/master-viewAgent-one/{{ $user->id }}" class="btn btn-warning"> View
                                                Profile</a>
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
                    <form action="{{ url('master-manageAgent/create') }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" id="name" onkeyup="alphabets(event);" onkeypress="return isAlphabetsKey(event)" class="form-control"
                                        name="name"  />
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
                                    <input type="text" id="ic" onkeyup="number(event);" class="form-control" onkeypress="return isNumberKey(event)"
                                        name="ic" />
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Email <span style="color:yellow">  *</span></label>
                                    <input type="text" id="email" class="form-control" name="email" />
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
                                         />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Phone Number <span style="color:yellow">  *</span></label>
                                    <input type="text" id="phoneNum" class="form-control" onkeyup="number(event);" onkeypress="return isNumberKey(event)" name="phone"
                                        />
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
                                        ></textarea>
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
                    <form action="{{ url('master-manageAgent/update') }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" id="nameEdit" class="form-control" onkeyup="alphabets(event);" onkeypress="return isAlphabetsKey(event)" name="nameEdit"
                                         />
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
                                    <input type="text" id="icEdit" class="form-control" onkeyup="number(event);" onkeypress="return isNumberKey(event)" name="icEdit"
                                        />
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Email <span style="color:yellow">  *</span></label>
                                    <input type="text" id="emailEdit" class="form-control" name="emailEdit"
                                         readonly/>
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
                                        />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Phone Number <span style="color:yellow">  *</span></label>
                                    <input type="text" id="phoneEdit" class="form-control" onkeyup="number(event);" onkeypress="return isNumberKey(event)" name="phoneEdit"
                                        />
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
                                        ></textarea>
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
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="viewName"></h4>
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

            document.getElementById('viewName').innerText = name;

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
