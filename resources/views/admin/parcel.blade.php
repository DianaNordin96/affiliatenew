@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blast Message</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                        <li class="breadcrumb-item active">Blast Message</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Credit Balance</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div style="text-align: center" class="card-body">
                            <h3>MYR {{ $balance }} </h3>
                            <a target="_blank" href="https://easyparcel.com/my/en/account/topup/"
                                class="btn btn-block bg-danger">Top Up</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Unpaid Created Consignment</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div style="text-align: center" class="card-body">
                    <button class="btn btn-warning" onclick="exportTableToExcelComplete()">Export Order
                        List to
                        Excel</button>
                    <br /><br />
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Courier</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consignment as $parcel)
                                <tr>
                                    <td><a href="/view-order-item/{{ $parcel->refNo }}">{{ $parcel->refNo }}</td>
                                    <td>{{ $parcel->name }}</td>
                                    <td>RM {{ number_format($parcel->price,2) }}</td>
                                    <td>{{ $parcel->courier }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    });

    document.getElementById("parcel").className = "nav-link active";

</script>
@endsection
