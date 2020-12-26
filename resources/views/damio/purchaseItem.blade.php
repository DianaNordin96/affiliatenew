@inject('tracking', 'App\Http\Controllers\Damio\PurchaseController')
@inject('order', 'App\Http\Controllers\Damio\PurchaseController')
@extends('layouts.damio')
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$referenceNo}}</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <div class="row">

                    <div class="col-lg-8">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($customerDetails as $customer)
                                    <div class="col-lg-3">
                                        <b>Name : {{ $customer->name }}</b><br />
                                        <b>Phone : {{ $customer->phone }}</b><br />
                                    </div>
                                    <div class="col-lg-9">
                                        <b>Address #1 : {{ $customer->address }}</b><br />
                                        <b>Address #2 : {{ $customer->address_two }}</b><br />
                                        <b>Address #3 : {{ $customer->address_three }}</b><br />
                                        <b>City : {{ $customer->city }}</b><br />
                                        <b>State : {{ $customer->state }}</b><br />
                                        <b>Postcode : {{ $customer->postcode }}</b><br />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                               <h3 class="card-title">Parcel Tracking</h3>

                               <?php $consignmentArray = $order->checkOrderExistConsignment($referenceNo); ?>
                                @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL )
                                    <?php 
                                    $trackingStatus = $tracking->getTrackingStatus($consignmentArray[0]->awb);
                                    $trackingDetails = $tracking->getTrackingDetails($consignmentArray[0]->awb);
                                    ?>

                                    Courier : {{$trackingDetails[0]->courier}}<br/>
                                    Tracking No : {{$trackingDetails[0]->awb}}<br/>
                                    @foreach($trackingStatus->result as $value)
                                        Latest Status : {{$value->latest_status}}<br/>
                                    @endforeach
                                @else
                                    <a style="color: red">Order not yet packed.</a>
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
                                                <td>{{ $product->price_hq + $product->price_shogun}}</td>
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

                </div>
    </div>
</div>

@endsection

@section('script')
    
@endsection
