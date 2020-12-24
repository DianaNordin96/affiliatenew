@inject('tracking', 'App\Http\Controllers\Merchant\PurchaseController')
@inject('order', 'App\Http\Controllers\Merchant\PurchaseController')
@extends('layouts.merchant')
@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-1 p-md-0">
            <button onclick="goBack()" type="button" class="btn btn-success"><i class="fa fa-angle-left"></i>
                Go Back</button>
            </div>
            <div class="col-sm-5 p-md-0">
                <div class="welcome-text">
                    <h4>Orders</h4>
                     <span>Purchase Item For {{ $referenceNo }}</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <div class="row">
                    <div class="col-lg-5">
                        <div class="card card-warning">
                            <div class="card-body">

                                <h3 class="card-title">Customer Details</h3>
                                <br/>

                               @foreach($customerDetails as $customer)
                                   <p><b>Name : {{$customer->name}}</b></p>
                                   <p><b>Phone : {{$customer->phone}}</b></p>
                                   <p><b>Address #1 : {{$customer->address}}</b></p>
                                   <p><b>Address #2 : {{$customer->address_two}}</b></p>
                                   <p><b>Address #3 : {{$customer->address_three}}</b></p>
                               @endforeach
                                
                               <br>
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

                    <div class="col-lg-7">
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
                                                <td>{{ $product->price_hq + $product->price_shogun + $product->price_damio}}</td>
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
