@inject('tracking', 'App\Http\Controllers\Admin\TrackingController')
@extends('layouts.admin')
@section('content')

@if(session('success_message'))
    <div class="alert alert-success">
        {{ session('success_message') }}
    </div>
@endif

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Manage Order</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-lightblue card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="false">Pending Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="true">Completed Order</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-warning" onclick="exportTableToExcelPending()">Export Order
                                                List to
                                                Excel</button>
                                            <br /><br />
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Created At</th>
                                                        <th>Amount</th>
                                                        <th>Agent Name</th>
                                                        <th>Item</th>
                                                        {{-- <th>Actions</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($orders_details_pending as $order)
                                                        <tr>
                                                            <td>{{ $order->orders_id }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                            <td>RM {{ number_format($order->amount,2) }}
                                                            </td>
                                                            <td>{{ $order->name }}</td>
                                                            <td>
                                                                <a class="btn btn-warning"
                                                                    href="/view-order-item/{{ $order->orders_id }}"><i
                                                                        class="far fa-eye"></i></a> &nbsp;
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-warning" onclick="exportTableToExcelComplete()">Export Order
                                                List to
                                                Excel</button>
                                            <br /><br />
                                            <table id="example3" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Created At</th>
                                                        <th>Amount</th>
                                                        <th>Agent Name</th>
                                                        <th>Tracking Status</th>
                                                        <th>Item</th>
                                                        {{-- <th>Actions</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($orders_details_complete as $order)
                                                        <tr>
                                                            <td>{{ $order->orders_id }}</td>
                                                            <td>{{ $order->created_at }}</td>
                                                            <td>RM {{ number_format($order->amount,2) }}
                                                            </td>
                                                            <td>{{ $order->name }}</td>
                                                            <td>{{ $tracking->getTrackingStatusSingle($order->tracking_number,$order->courier_code) }}
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-warning"
                                                                    href="/view-order-item/{{ $order->orders_id }}"><i
                                                                        class="far fa-eye"></i></a> &nbsp;
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
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $("#example3").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });

    document.getElementById("view-order").className = "nav-link active";

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
