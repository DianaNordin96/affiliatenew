@inject('category', 'App\Http\Controllers\MasterAdmin\ManageAdminController')
@extends('layouts.masteradmin')
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
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('MasterDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Agents</li>
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
                    <div class="col-lg-4">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Admin Category</h3>
    
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                    data-target="#addAdminCat">
                                    <i class="fas fa-plus"></i> &nbsp Add Admin Category
                                </button><br/>
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category ID</th>
                                            <th>Cat Name</th>
                                            <th>Cat Desc</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allTypeAdmin as $value)
                                            <tr>
                                                <td style="text-align: center">{{ $value->id }}</td>
                                                <td style="text-align: center">{{ $value->category }}</td>
                                                <td style="text-align: center">{{ $value->desc }}</td>
                                                <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                    onclick="openModalEdit(
                                                        '{{ $value->id }}',
                                                        '{{ $value->category }}',
                                                        '{{ $value->desc }}'
                                                        )"
                                                    data-target="#editCategory" class="btn btn-success"><i
                                                        class="fas fa-edit"></i></button> &nbsp;</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div  class="col-lg-8">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">List of Admin</h3>
    
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                
                                <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                    data-target="#addAdmin">
                                    <i class="fas fa-plus"></i> &nbsp Add Admin
                                </button><br/>
                            
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                {{-- <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                    data-target="#modal-lg">
                                    <i class="fas fa-plus"></i> &nbsp Add Users
                                </button>
                                <br /> --}}
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>IC Number</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Admin Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allAdmin as $user)
                                            <tr>
                                                <td style="text-align: center">{{ $user->id }}</td>
                                                <td style="text-align: center">{{ $user->icnumber }}</td>
                                                <td style="text-align: center">{{ $user->name }}</td>
                                                <td style="text-align: center">{{ $user->email }}</td>
                                                <td style="text-align: center">{{ $user->phone }}</td>
                                                <td style="text-align: center">
                                                    <select onchange="location = this.value;" class="btn btn-default">
                                                        @foreach($allTypeAdmin as $key => $value)
                                                        <option value="/change-admin-type/{{$user->id}}/{{$value->id}}" @if($user->admin_category == $value->id){ selected }  @endif>{{$value->category}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="text-align: center">
                                                    <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                            onclick="window.location.href='/master.remove.admin/{{ $user->id }}'"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
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
            </div><!-- /.container-fluid -->

            {{-- modal add admin --}}
            <div class="modal fade" id="addAdmin">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Admin</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('master.create.admin') }}" method="post" enctype="multipart/form-data">
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
                                    <?php $allAdminType = $category->getAllAdminType(); ?>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Admin Group </label>
                                            <select class="form-control" id="category" name="category">
                                                @foreach($allAdminType as $value)
                                                    <option value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-sm-6">
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
                                    <button type="submit" class="btn btn-primary">Add Admin</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div> 

            {{-- modal add admin cat --}}
            <div class="modal fade" id="addAdminCat">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Admin Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('master.create.adminCat') }}" method="post" enctype="multipart/form-data">
                                @csrf
                               
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Category Name </label>
                                            <input type="text" id="catName" class="form-control" name="catName"
                                                placeholder="Category Name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="3"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

             {{-- modal edit admin cat --}}
            <div class="modal fade" id="editCategory">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Admin Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('master.update.adminCat') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" id="idEdit" class="form-control" name="idEdit"
                                placeholder="Category Name" hidden/>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Category Name </label>
                                            <input type="text" id="catNameEdit" class="form-control" name="catNameEdit"
                                                placeholder="Category Name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="descEdit" id="descEdit" rows="3"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Category</button>
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
                <div class="modal-dialog modal-sm">
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

        document.getElementById("manageAdmin").className = "nav-link active";

        function openModalEdit(id, cat, desc) {

            document.getElementById("idEdit").value = id;
            document.getElementById("catNameEdit").value = cat;
            document.getElementById("descEdit").value = desc;
        }

        function openModalView(id, name, email, phone, address) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<b>Name  </b>" + "<br/>" + name + "<br/>" +
                "<b>Email  </b>" + "<br/>" + email + "<br/>" +
                "<b>Phone Number  </b>" + "<br/>" + phone + "<br/>" +
                "<b>Address  </b>" + "<br/>" + address + "<br/>" +
                "</div>";
        }

    </script>
@endsection
