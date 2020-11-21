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
                    <h1 class="m-0 text-dark">Order Pending</h1>
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
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-warning" onclick="exportTableToExcelPending()">Export Order
                                        List to
                                        Excel</button>
                                <br /><br />
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="noExport">Order ID</th>
                                                <th class="noExport">Created At</th>
                                                <th class="noExport">Amount</th>
                                                <th class="noExport">Agent Name</th>
                                                <th class="noExport">Item</th>
                                                {{-- <th>Actions</th> --}}

                                                {{-- table for export --}}
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
                                                            href="/view-order-item/{{ $order->orders_id }}"><i
                                                                class="far fa-eye"></i></a> &nbsp;
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
                                                        <select name="courier">
                                                            <option value="Pgeon Delivery">Pgeon Delivery</option>
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
                                                    <td hidden>
                                                        <select name="alt_courier">
                                                            <option value="Pgeon Delivery">Pgeon Delivery</option>
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
                                                        <select name="sms">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </td>
                                                    <td hidden>
                                                        <select name="dropoff">
                                                        <option value="Yes">Yes</option>
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

    document.getElementById("pendingOrder").className = "nav-link active";
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
