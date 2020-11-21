@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@inject('order', 'App\Http\Controllers\Admin\ManageOrderController')
@extends('layouts.admin')
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                    <?php $consignmentArray = $order->checkOrderExistConsignment($referenceNo); ?>
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Rate Checking</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($consignmentArray) == 0)
                            <form action="{{url('parcel-create')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <select id="state" class="form-control select2bs4" name="state" >
                                                <option value="jhr" >Johor</option>
                                                <option value="kdh" >Kedah</option>
                                                <option value="ktn" >Kelantan</option>
                                                <option value="mlk" >Melaka</option>
                                                <option value="nsn" >Negeri Sembilan </option>
                                                <option value="phg" >Pahang</option>
                                                <option value="prk" >Perak</option>
                                                <option value="pls" >Perlis</option>
                                                <option value="png" >Pulau Pinang</option>
                                                <option value="sgr" >Selangor</option>
                                                <option value="trg" >Terengganu</option>
                                                <option value="kul" >Kuala Lumpur</option>
                                                <option value="pjy" >Putra Jaya</option>
                                                <option value="srw" >Sarawak</option>
                                                <option value="sbh" >Sabah</option>
                                                <option value="lbn" >Labuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Postcode</label>
                                            <input type="text" name="senderPostcode" maxlength="5" placeholder="Sender Postcode" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="refNo" value="{{$referenceNo}}" hidden/>
                                    <input style="width:50%" type="text" id="weight" class="form-control"
                                            name="weight" placeholder="Parcel Weight in KG" />
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-flat">Check!</button>
                                    </span>
                                </div>
                            </form>
                            @elseif(count($consignmentArray) != 0 && $consignmentArray[0]->awb == NULL)
                            <h6 style="color: red">Parcel already recorded in <a href="/parcel">Unpaid Consignment</a></h6>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                   

                    <div class="card card-warning collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($customerDetails as $customer)
                                <b>Name : {{ $customer->name }}</b><br/>
                                <b>Phone : {{ $customer->phone }}</b><br/>
                                <b>Address #1 : {{ $customer->address }}</b><br/>
                                <b>Address #2 : {{ $customer->address_two }}</b><br/>
                                <b>Address #3 : {{ $customer->address_three }}</b><br/>
                                <b>City : {{ $customer->city }}</b><br/>
                                <b>State : {{ $customer->state }}</b><br/>
                                <b>Postcode : {{ $customer->postcode }}</b><br/>
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
                            @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL )
                                <?php $trackingStatus = $tracking->getTrackingStatus($consignmentArray['awb']); ?>
                                @foreach($trackingStatus->data as $value)
                                    Tracking Number : {{$value->tracking_number}}<br/>
                                    Parcel Status : {{$value->status}}<br/>
                                    Last Activity : {{$value->lastEvent}}
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
                            
                            <a onclick="goBack()" class="btn btn-warning"><i
                                    class="fa fa-angle-left"></i>
                                Go Back</a>
                            
                            <br /><br />


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
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="col-sm-3 hidden-xs"><img
                                                        src="/imageUploaded/{{ $product->product_image }}" width="100"
                                                        height="100" class="img-responsive" /></div>
                                            </td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->price_shogun }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            {{-- <td>
                                                <a class="btn btn-warning" href="view-purchased-product/{{ $orderDetail->orders_id }}"><i
                                                class="far fa-eye"></i>&nbsp; View item</a> &nbsp;
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

    </section>
    <!-- /.content -->
</div>
<!-- /.card -->


@endsection

@section('script')
<!-- Bootstrap Switch -->
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>
    $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
    
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
        
    $(function () {
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
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    });

    document.getElementById("view-order").className = "nav-link active";

    function goBack() {
    window.history.back();
    }

</script>

@endsection
