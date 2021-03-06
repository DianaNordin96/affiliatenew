@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@inject('order', 'App\Http\Controllers\Admin\ManageOrderController')
@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-2 p-md-0">
                <button onclick="goBack()" type="button" class="btn btn-success"><i class="fa fa-angle-left"></i>
                    Go Back</button>
                </div>
                <div class="col-sm-4 p-md-0">
                    <div class="welcome-text">
                        <h4>Orders</h4>
                         <span>Purchase Item For {{ $referenceNo }}</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $referenceNo }}</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            
            <div class="row">
                <div class="col-lg-4">
                    <?php $consignmentArray = $order->checkOrderExistConsignment($referenceNo); ?>
                    <div class="card card-warning overflow-hidden">
                        <div class="card-header">
                            <h3 class="card-title">Rate Checking</h3>
                        </div>
                        <div class="card-body ">
                            @if (count($consignmentArray) == 0)
                                <form action="{{ url('parcel-create') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select class="select2-width-75" style="width: 75%" id="state" name="state">
                                                    <option value="jhr">Johor</option>
                                                    <option value="kdh">Kedah</option>
                                                    <option value="ktn">Kelantan</option>
                                                    <option value="mlk">Melaka</option>
                                                    <option value="nsn">Negeri Sembilan </option>
                                                    <option value="phg">Pahang</option>
                                                    <option value="prk">Perak</option>
                                                    <option value="pls">Perlis</option>
                                                    <option value="png">Pulau Pinang</option>
                                                    <option value="sgr">Selangor</option>
                                                    <option value="trg">Terengganu</option>
                                                    <option value="kul">Kuala Lumpur</option>
                                                    <option value="pjy">Putra Jaya</option>
                                                    <option value="srw">Sarawak</option>
                                                    <option value="sbh">Sabah</option>
                                                    <option value="lbn">Labuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Postcode</label>
                                                <input type="text" name="senderPostcode" maxlength="5"
                                                    placeholder="Sender Postcode" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="refNo" value="{{ $referenceNo }}" hidden />
                                        <input style="width:50%" type="text" id="weight" onkeyup="number(event);" onkeypress="return isNumberKey(event)"
                                        class="form-control" name="weight"
                                            placeholder="Parcel Weight in KG" />
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Check!</button>
                                        </span>
                                    </div>
                                </form>
                            @elseif(count($consignmentArray) != 0 && $consignmentArray[0]->awb == NULL)
                                <h6 style="color: red">Parcel already recorded in <a href="/parcel">Unpaid Consignment</a>
                                </h6>
                                <h6 style="color: red">Delete the existed consignment created <a target="_blank"
                                        href="/parcel">here</a> to create new consignment for this order.</h6>
                            @elseif(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL)
                                <h6 style="color: red">Parcel has been posted.</a></h6>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($customerDetails as $customer)
                                <b>Name : {{ $customer->name }}</b><br />
                                <b>Phone : {{ $customer->phone }}</b><br />
                                <b>Address #1 : {{ $customer->address }}</b><br />
                                <b>Address #2 : {{ $customer->address_two }}</b><br />
                                <b>Address #3 : {{ $customer->address_three }}</b><br />
                                <b>City : {{ $customer->city }}</b><br />
                                <b>State : {{ $customer->state }}</b><br />
                                <b>Postcode : {{ $customer->postcode }}</b><br />
                                <b>Notes : {{ $customer->notes }}</b><br />
                            @endforeach
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-warning collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Parcel Tracking</h3>
                        </div>
                        <div class="card-body">
                            @if (count($consignmentArray) != 0 && $consignmentArray[0]->awb != null)
                                <?php $trackingStatus =
                                $tracking->getTrackingStatus($consignmentArray[0]->awb); 
                                $trackingDetails = $order->getTrackingDetails($consignmentArray[0]->awb);?>
                                 Courier : {{$trackingDetails[0]->courier}}<br/>
                                 Tracking No : {{$trackingDetails[0]->awb}}<br/>
                                @foreach ($trackingStatus->result as $value)
                                    Latest Status : {{ $value->latest_status }}<br />
                                @endforeach
                            @else
                                <h6 style="color: red">Order not yet packed.</h6>
                            @endif

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                    
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price (RM) /each</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <div class="col-sm-3 hidden-xs"><img
                                                        src="{{asset('imageUploaded/products/'.$product->product_image.'')}}" 
                                                            width="100" height="100" class="img-responsive" /></div>
                                                </td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->price_shogun }}</td>
                                                <td>{{ $product->quantity }}</td>
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
    <!-- /.card -->


@endsection

@section('script')
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>
        
        

    </script>

@endsection
