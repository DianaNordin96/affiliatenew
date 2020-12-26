@extends('layouts.shogun')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Customers</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->



            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h3 class="card-title">View Employee</h3> -->
                            {{-- <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                data-target="#modal-lg">
                                <i class="fas fa-plus"></i> &nbsp Add Customers
                            </button>
                            <br /> --}}
                            <div class="table-responsive">
                                <table id="example5" class="display example5" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th width="40%">Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->address }}</td>
                                            <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                    onclick="openModalEdit(
                                                                            '{{ $customer->id }}',
                                                                            '{{ $customer->name }}',
                                                                            '{{ $customer->phone }}',
                                                                            '{{ $customer->address }}',
                                                                            '{{ $customer->address_two }}',
                                                                            '{{ $customer->address_three }}',
                                                                            '{{ $customer->email }}',
                                                                            '{{ $customer->state }}',
                                                                            '{{ $customer->postcode }}',
                                                                            '{{ $customer->city }}'
                                                                            )" data-target="#modalEdit"
                                                    class="btn btn-warning"><i class="lni lni-pencil-alt"></i></button> &nbsp;
                                                <button type="button" title="View" data-toggle="modal" onclick="openModalView(
                                                                             '{{ $customer->id }}',
                                                                            '{{ $customer->name }}',
                                                                            '{{ $customer->phone }}',
                                                                            '{{ $customer->address }}',
                                                                            '{{ $customer->address_two }}',
                                                                            '{{ $customer->address_three }}',
                                                                            '{{ $customer->email }}',
                                                                            '{{ $customer->state }}',
                                                                            '{{ $customer->postcode }}',
                                                                            '{{ $customer->city }}'
                                                                            )" data-target="#modalView"
                                                    class="btn btn-success"><i class="lni lni-eye"></i></button> &nbsp;

                                                <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                    onclick="window.location.href='customers-shogun-delete/{{ $customer->id }}'"
                                                    class="btn btn-danger"><i class="lni lni-trash"></i></i></button>
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
        
        

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('customers-shogun-add') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label> Customer Name </label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            placeholder="Name" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->

                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address" id="address" rows="3"
                                            placeholder="Address"></textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label> Phone Number </label>
                                        <input type="text" id="phone" class="form-control" name="phone"
                                            placeholder="Phone Number" />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Customer</button>
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
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Customer Details</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('customers-shogun-update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="customerID" id="customerID" hidden />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Customer Name <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="nameEdit" class="form-control" name="nameEdit"
                                                    placeholder="Name" required />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Phone Number <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="phoneEdit" onkeypress="return isNumberKey(event)" class="form-control" name="phoneEdit"
                                                    placeholder="Phone Number" required />
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Address #1 <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="address1Edit" class="form-control" name="address1Edit"
                                                    placeholder="" required />
                                            </div>
                                        </div>
    
                                        <div class="col-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Email </label>
                                                <input type="text" id="emailEdit" class="form-control" name="emailEdit"
                                                    placeholder="Email" />
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Address #2 (Optional) </label>
                                                <input type="text" id="address2Edit" class="form-control" name="address2Edit"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Address #3 (Optional) </label>
                                                <input type="text" id="address3Edit" class="form-control" name="address3Edit"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>City <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="cityEdit" class="form-control" name="cityEdit" placeholder=""
                                                    required />
                                            </div>
                                        </div>
    
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>State <span style="color:yellow">  *</span>
                                                </label>
                                                <select class="select2-width-75" style="width: 75%" style="width: 100%;" id="stateEdit" name="stateEdit">
                                                    <option id="jhr" value="jhr">Johor</option>
                                                    <option id="kdh" value="kdh">Kedah</option>
                                                    <option id="ktn" value="ktn">Kelantan</option>
                                                    <option id="mlk" value="mlk">Melaka</option>
                                                    <option id="nsn" value="nsn">Negeri Sembilan </option>
                                                    <option id="phg" value="phg">Pahang</option>
                                                    <option id="prk" value="prk">Perak</option>
                                                    <option id="pls" value="pls">Perlis</option>
                                                    <option id="png" value="png">Pulau Pinang</option>
                                                    <option id="sgr" value="sgr">Selangor</option>
                                                    <option id="trg" value="trg">Terengganu</option>
                                                    <option id="kul" value="kul">Kuala Lumpur</option>
                                                    <option id="pjy" value="pjy">Putra Jaya</option>
                                                    <option id="srw" value="srw">Sarawak</option>
                                                    <option id="sbh" value="sbh">Sabah</option>
                                                    <option id="lbn" value="lbn">Labuan</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Postcode <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="postcodeEdit" onkeypress="return isNumberKey(event)" class="form-control" name="postcodeEdit"
                                                    placeholder="" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                        <h4 class="modal-title">Customer Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-view">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</div>
@endsection

@section('script')
<script>

    function openModalEdit(id,name,phone,address1,address2,address3,email,state,postcode,city) {

        document.getElementById("customerID").value = id;
        document.getElementById("nameEdit").value = name;
        document.getElementById("address1Edit").value = address1;
        document.getElementById("address2Edit").value = address2;
        document.getElementById("address3Edit").value = address3;
        document.getElementById("emailEdit").value = email;
        $('#stateEdit').val(state).change();
        document.getElementById("postcodeEdit").value = postcode;
        document.getElementById("cityEdit").value = city;
        document.getElementById("phoneEdit").value = phone;
    }

    function openModalView(id,name,phone,address1,address2,address3,email,state,postcode,city) {

        document.getElementById("modal-body-view").innerHTML =
            "<div class='row'>" +
            "<br/>" +
            "<div class='col-lg-6'>" +
            "<b>Customer Name:  </b>" + name + "<br/>" +
            "<b>Phone Number: </b>" + phone + "<br/>" +
            "</div><div class='col-lg-6'><b>Address: </b> " + address1 + "<br/>" +
            "<b>Address: </b> " + address2 + "<br/>" +
            "<b>Address: </b> " + address3 + "<br/>" +
            "<b>Email: </b> " + email + "<br/>" +
            "<b>State: </b> " + state + "<br/>" +
            "<b>Postcode: </b> " + postcode + "<br/>" +
            "<b>City: </b> " + city + "<br/>" +
            "</div>";
        "</div>";
    }

</script>
@endsection
