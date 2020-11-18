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
                        <h1>Create Consignment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                            <li class="breadcrumb-item active">Create Consignment</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Rate Checking</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Courier</th>
                                            <th>Service Detail</th>
                                            <th>Price</th>
                                            <th>Pickup Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ratesList as $value)
                                            <tr>
                                                <td>1.</td>
                                                <td>
                                                    <img style="width:20%;height:50%" class="img-responsive" src="{{ $value->courier_logo }}" /><br>
                                                    {{$value->courier_name}} <br>
                                                </td>
                                                <td>{{$value->service_detail}}</td>
                                                <td>
                                                    {{$value->shipment_price}}
                                                </td>
                                                <td>
                                                    {{$value->pickup_date}}
                                                </td>
                                                <td>
                                                <button class="btn btn-block bg-danger" href="{{$value->service_id}}">Choose</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Sender Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                The body of the card
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-warning shadow collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Receiver Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                The body of the card
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-warning shadow collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Parcel Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                The body of the card
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-4">
                        <div class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Total</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                The body of the card
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
        document.getElementById("blastMessage").className = "nav-link active";

    </script>
@endsection
