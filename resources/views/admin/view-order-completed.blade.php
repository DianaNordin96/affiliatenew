@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@extends('layouts.admin')
@section('content')

@if(session('success_message'))
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
                                    <button class="btn btn-warning" onclick="exportTableToExcelComplete()">Export Order
                                        List to
                                        Excel</button>
                                    <br /><br />
                                    <div class="table-responsive">
                                        <table id="example5" class="display" style="width:100%">
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
    function exportTableToExcelPending() {
        $(document).ready(function () {
            $("#example1").table2excel({
                exclude: ".noExport",
                filename: "Order List"
            });
        });
    }

    function exportTableToExcelComplete() {
        $(document).ready(function () {
            $("#example3").table2excel({
                exclude: ".noExport",
                filename: "Order List"
            });
        });
    }

    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $("#example3").DataTable({
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

    document.getElementById("completedOrder").className = "nav-link active";
    document.getElementById("menuOrder").className = "nav-link active";
    document.getElementById("menuOrders").className = "nav-item menu-open has-treeview";

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
