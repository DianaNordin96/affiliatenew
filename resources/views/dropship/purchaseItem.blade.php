@inject('tracking', 'App\Http\Controllers\Dropship\PurchaseController')
@inject('order', 'App\Http\Controllers\Dropship\PurchaseController')
@extends('layouts.dropship')
@section('headScript')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Purchase Item For {{ $referenceNo }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('DropshipDashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Purchase History</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-5">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
    
                                {{-- <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                  <i class="fas fa-times"></i>
                                </button>
                              </div> --}}
                            </div>
                            <div class="card-body">
                               @foreach($customerDetails as $customer)
                                   <p><b>Name : {{$customer->name}}</b></p>
                                   <p><b>Phone : {{$customer->phone}}</b></p>
                                   <p><b>Address #1 : {{$customer->address}}</b></p>
                                   <p><b>Address #2 : {{$customer->address_two}}</b></p>
                                   <p><b>Address #3 : {{$customer->address_three}}</b></p>
                               @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                        
                        <div class="card card-warning collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Parcel Tracking</h3>
    
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
    
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                // dd($consignmentArray);
                                ?>
                                <?php $consignmentArray = $order->checkOrderExistConsignment($referenceNo); ?>
                                @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL )
                                <?php $trackingStatus = $tracking->getTrackingStatus($consignmentArray[0]->awb); 
                            
                                ?>
                                @foreach($trackingStatus->result as $value)
                                    Latest Status : {{$value->latest_status}}<br/>
                                @endforeach
                            @else
                            <h6 style="color: red">Order not yet packed.</h6>
                            @endif
                                
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                <a href="{{ url('/purchase-history-dropship') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                    Go Back</a>
                                    <br/><br/>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price (RM) /each</th>
                                            <th>Quantity</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td><div class="col-sm-3 hidden-xs"><img
                                                    src="../imageUploaded/products/{{ $product->product_image }}" width="100"
                                                    height="100" class="img-responsive" /></div></td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->price_shogun + $product->price_hq + $product->price_damio + $product->price_merchant}}</td>
                                                <td>{{ $product->quantity }}</td>
                                                {{-- <td>
                                                <a class="btn btn-warning" href="view-purchased-product/{{$orderDetail->orders_id}}"><i class="far fa-eye"></i>&nbsp; View item</a> &nbsp;
                                                </td> --}}
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
    <!-- /.card -->


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

        document.getElementById("history").className = "nav-link active";

    </script>
@endsection
