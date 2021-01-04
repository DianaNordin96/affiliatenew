@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@extends('layouts.admin')
@section('content')

<div class="content-body">
    <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Orders</h4>
                        <span>Completed Orders</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Completed Order</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-warning" onclick="exportTableToExcel()">Export Order List to
                                        Excel</button>
                                    <br /><br />
                                    <div class="table-responsive">
                                        <table id="example5" class="display example5" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Created At</th>
                                                <th>Amount</th>
                                                <th>Agent Name</th>
                                                {{-- <th>Tracking Status</th> --}}
                                                <th>Item</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders_details_complete as $order)
                                                <tr>
                                                    <td>{{ $order->orders_id }}</td>
                                                    <td>{{ $order->order_created }}</td>
                                                    <td>RM {{ number_format($order->amount,2) }}</td>
                                                    <td>{{ $order->name }}</td>
                                                    {{-- <td>{{ $tracking->getTrackingStatusSingle($order->tracking_number,$order->courier_code) }}</td> --}}
                                                    <td>
                                                        <a class="btn btn-warning"
                                                        href="/view-order-item/{{ $order->orders_id }}"></i>View Order</a> &nbsp;
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
    </div>
</div>

@endsection

@section('script')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"> </script>
<script>
    function exportTableToExcel() {
        $(document).ready(function () {
            $(".example5").table2excel({
                exclude: ".noExport",
                filename: "Complete Orders List"
            });
        });
    }

    var table = $('#example5').DataTable();
 
 // Sort by column 1 and then re-draw
 table
     .order( [ 0, 'desc' ] )
     .draw();

</script>
@endsection
