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
                        <h1 class="m-0 text-dark">Manage Order</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Order</li>
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
                                    <i class="fas fa-plus"></i> &nbsp Add Users
                                </button>
                                <br />
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Created At</th>
                                            <th>Agent Name</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_details as $order)
                                            <tr>
                                                <td>{{ $order->order_id }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->product_name }}</td>
                                                <td></td>
                                        </tr>
                                        @endforeach
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

                                    <div class="col-sm-6">
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
                                    <div class="col-sm-6">
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
                                    <button type="submit" class="btn btn-primary">Add Users</button>
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <input type="text" id="idEdit" class="form-control" name="idEdit"
                                                placeholder="Name" hidden />
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

                                    <div class="col-sm-6">
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
                                    <div class="col-sm-6">
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
                                    <div class="col-sm-6">
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

        document.getElementById("customerDetails").className = "nav-link active";

        function openModalEdit(id, name, email, phone, address) {

            document.getElementById("idEdit").value = id;
            document.getElementById("nameEdit").value = name;
            document.getElementById("emailEdit").value = email;
            document.getElementById("phoneEdit").value = phone;
            document.getElementById("addressEdit").value = address;

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
