@inject('tracking', 'App\Http\Controllers\Dropship\PurchaseController')
@inject('order', 'App\Http\Controllers\Dropship\PurchaseController')
@extends('layouts.dropship')
@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Purchase History</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Purchase History</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->

                                <div class="table-responsive">
                                    <table id="example5" class="display">
                                    <thead>
                                        <tr>
                                            <th>Purchased At</th>
                                            <th>Orders ID</th>
                                            <th>Bill Code</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Amount (RM)</th>
                                            <th>Items</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            {{-- <th>View Receipt</th>
                                            --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_detail as $orderDetail)
                                            <tr>
                                                <td>{{ $orderDetail->created_at }}</td>
                                                <td>{{ $orderDetail->orders_id }}</td>
                                                <td>{{ $orderDetail->bill_code }}</td>
                                                <td>{{ $orderDetail->name }}</td>
                                                <td>{{ $orderDetail->phone }}</td>
                                                <td>{{ number_format($orderDetail->amount, 2) }}</td>
                                                <td>
                                                    <?php 
                                                        $products = $order->getProducts($orderDetail->orders_id)?> 
                                                    
                                                    @foreach ($products as $prod)
                                                        {{$prod->product_name}} ,
                                                    @endforeach
                                                </td>
                                                <td>

                                                    <?php $consignmentArray = $order->checkOrderExistConsignment($orderDetail->orders_id);
                                                    ?>
                                                    @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL )
                                                    <?php $trackingStatus = $tracking->getTrackingStatus($consignmentArray[0]->awb);?>
                                                    @foreach($trackingStatus->result as $value)
                                                        Courier : {{$consignmentArray[0]->courier}}<br/>
                                                        Tracking No : {{$consignmentArray[0]->awb}}<br/>
                                                        Latest Status : {{$value->latest_status}}<br/>
                                                    @endforeach
                                                    @else
                                                    <a style="color: red">Order not yet packed.</a>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="/view-purchased-product-dropship/{{ $orderDetail->orders_id }}"></i>&nbsp; View Order</a> &nbsp;
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
        </section>
        <!-- /.content -->
    </div>
    <!-- /.card -->


@endsection

@section('script')
<script>
     var table = $('#example5').DataTable();
 
 // Sort by column 1 and then re-draw
 table
     .order( [ 0, 'desc' ] )
     .draw();
</script>
@endsection
