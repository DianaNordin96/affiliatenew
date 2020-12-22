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
                    <h4>Paid Parcels</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Paid Parcels</a></li>
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
                                    <div class="table-responsive">
                                        <table id="example5" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Paid At</th>
                                                <th>Ref No</th>
                                                <th>AirwayBill No</th>
                                                <th>Courier</th>
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
                                                        <?php $date=date_create($order->updated_at); ?> 
                                                        {{date_format($date,"d/m/Y h:i A")}}</td>
                                                    <td><a href="/view-order-item/{{$order->refNo}}">{{$order->refNo}}</a></td>
                                                    <td>{{$order->awb}}</td>
                                                    <td>{{$order->courier}}</td>
                                                    <td>
                                                        @if($order->awb_id_link != '')
                                                        <a target="_blank" href="{{$order->awb_id_link}}" download>Consignment note</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($order->tracking_url != '')
                                                        <a target="_blank" href="{{$order->tracking_url}}">Click here to track parcel</a>
                                                        @endif
                                                    </td>
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
