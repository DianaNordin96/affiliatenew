@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@inject('orders', 'App\Http\Controllers\Admin\ManageOrderController')
@extends('layouts.admin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Orders</h4>
                        <span>Pending Orders</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pending Orders</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-warning" onclick="exportTableToExcel()">Export Order
                                List to
                                Excel</button>
                            <br /><br />
                            <div class="table-responsive">
                                <table id="example5" class="display example5">
                                    <thead>
                                        <tr>
                                            <th class="noExport">Order ID</th>
                                            <th class="noExport">Created At</th>
                                            <th class="noExport">Amount</th>
                                            <th class="noExport">Agent Name</th>
                                            <th class="noExport"></th>
                                            <th class="noExport"></th>
                                            <th hidden>No*</th>
                                            <th hidden>Category</th>
                                            <th hidden>Parcel Content*</th>
                                            <th hidden>Parcel Value (RM)*</th>
                                            <th hidden>Weight (kg)*</th>
                                            <th hidden>Pick Up Date*</th>
                                            <th hidden>Sender Name*</th>
                                            <th hidden>Sender Company</th>
                                            <th hidden>Sender Contact*</th>
                                            <th hidden>Sender Alt Contact</th>
                                            <th hidden>Sender Email</th>
                                            <th hidden>Sender Address*</th>
                                            <th hidden>Sender Postcode*</th>
                                            <th hidden>Sender City*</th>
                                            <th hidden>Receiver Name*</th>
                                            <th hidden>Receiver Company</th>
                                            <th hidden>Receiver Contact*</th>
                                            <th hidden>Receiver Alt Contact</th>
                                            <th hidden>Receiver Email</th>
                                            <th hidden>Receiver Address*</th>
                                            <th hidden>Receiver Postcode*</th>
                                            <th hidden>Receiver City*</th>
                                            <th hidden>Courier Company List</th>
                                            <th hidden>Courier Company</th>
                                            <th hidden>Alternative Courier Company</th>
                                            <th hidden>Tracking SMS (RM0.20)</th>
                                            <th hidden>Drop Off At Courier Branch</th>
                                            <th hidden>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; 
                                        // dd($orders_details_pending);
                                        ?>
                                        @foreach($orders_details_pending as $order)
                                            <tr>
                                                <td class="noExport">{{ $order->orders_id }}</td>
                                                <td class="noExport">{{ $order->order_created }}</td>
                                                <td class="noExport">RM {{ number_format($order->amount,2) }}
                                                </td>
                                                <td class="noExport">{{ $order->name }}</td>
                                                <td class="noExport">
                                                    <a class="btn btn-warning"
                                                        href="/view-order-item/{{ $order->orders_id }}"></i>View Order</a> &nbsp;
                                                </td>
                                                <td class="noExport">
                                                    <?php $consignmentArray = $orders->checkOrderExistConsignment($order->orders_id); ?>
                                                    @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb == NULL)
                                                        <a style="color: red">Parcel already recorded in <a href="/parcel">Unpaid Consignment</a></a>
                                                    @else
                                                        <a style="color: red">No consignment created yet</a>
                                                    @endif
                                                </td>
                                                <td hidden>{{ $no }}</td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden>{{ $order->amount }}</td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden>{{ $order->cust_name }}</td>
                                                <td hidden></td>
                                                <td hidden>{{ $order->phone }}</td>
                                                <td hidden></td>
                                                <td hidden></td>
                                                <td hidden>{{ $order->address}},{{$order->address_two}},{{$order->address_three}}</td>
                                                <td hidden>{{ $order->postcode }}</td>
                                                <td hidden>{{ $order->city }}</td>
                                                <td hidden>
                                                    <select>
                                                        <option value="Pgeon Delivery" selected>Pgeon Delivery</option>
                                                        <option value="Pgeon Prime">Pgeon Prime</option>
                                                        <option value="Skynet">Skynet</option>
                                                        <option value="Poslaju">Poslaju</option>
                                                        <option value="SNT">SNT</option>
                                                        <option value="ABX">ABX</option>
                                                        <option value="DHL eCommerce">DHL eCommerce</option>
                                                        <option value="Aramex">Aramex</option>
                                                        <option value="CJ Century">CJ Century</option>
                                                        <option value="UTS">UTS</option>
                                                        <option value="ULTIMATE CONSOLIDATORS">ULTIMATE CONSOLIDATORS</option>
                                                        <option value="Qxpress">Qxpress</option>
                                                        <option value="GOLOG Flower Delivery">GOLOG Flower Delivery</option>
                                                        <option value="GOLOG On Demand">GOLOG On Demand</option>
                                                        <option value="Transprompt Freight">Transprompt Freight</option>
                                                        <option value="J&T Express">J&T Express</option>
                                                    </select>
                                                </td>
                                                <td hidden></td>
                                                <td hidden>
                                                    <select>
                                                        <option value="Pgeon Delivery" selected>Pgeon Delivery</option>
                                                        <option value="Pgeon Prime">Pgeon Prime</option>
                                                        <option value="Skynet">Skynet</option>
                                                        <option value="Poslaju">Poslaju</option>
                                                        <option value="SNT">SNT</option>
                                                        <option value="ABX">ABX</option>
                                                        <option value="DHL eCommerce">DHL eCommerce</option>
                                                        <option value="Aramex">Aramex</option>
                                                        <option value="CJ Century">CJ Century</option>
                                                        <option value="UTS"></option>
                                                        <option value="ULTIMATE CONSOLIDATORS">ULTIMATE CONSOLIDATORS</option>
                                                        <option value="Qxpress">Qxpress</option>
                                                        <option value="GOLOG Flower Delivery">GOLOG Flower Delivery</option>
                                                        <option value="GOLOG On Demand">GOLOG On Demand</option>
                                                        <option value="Transprompt Freight">Transprompt Freight</option>
                                                        <option value="J&T Express">J&T Express</option>
                                                    </select>
                                                </td>
                                                <td hidden>
                                                    <select>
                                                        <option value="Yes" selected>Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                                <td hidden>
                                                    <select>
                                                    <option value="Yes" selected>Yes</option>
                                                    <option value="No">No</option>
                                                    </select>
                                                </td>
                                                <td hidden>{{ $order->orders_id }}</td>
                                            </tr>
                                            <?php $no++;?>
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
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"> </script>
<script>
    function exportTableToExcel() {
        $(document).ready(function () {
            $(".example5").table2excel({
                exclude: ".noExport",
                filename: "Pending Order List"
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