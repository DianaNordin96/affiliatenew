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
                    <h1 class="m-0 text-dark">Paid Parcel</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Paid Parcel</li>
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
                                                <th>Created At</th>
                                                <th>Ref No</th>
                                                <th>AirwayBill No</th>
                                                <th>AirwayBill Consignment Note</th>
                                                <th>Tracking Url</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; 
                                            // dd($orders_details_pending);
                                            ?>
                                            @foreach($consignment as $order)
                                                <tr>
                                                    <td>
                                                        <?php $date=date_create($order->created_at); ?> 
                                                        {{date_format($date,"d/m/Y h:i A")}}</td>
                                                    <td><a href="/view-order-item/{{$order->refNo}}">{{$order->refNo}}</a></td>
                                                    <td>{{$order->awb}}</td>
                                                    <td><a target="_blank" href="{{$order->awb_id_link}}" download>Consignment note</a></td>
                                                    <td><a target="_blank" href="{{$order->tracking_url}}">Click here to track parcel</a></td>
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

    document.getElementById("paid-parcel").className = "nav-link active";
    document.getElementById("menuParcel").className = "nav-link active";
    document.getElementById("menuParcels").className = "nav-item menu-open has-treeview";
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
