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
                    <div class="col-md-12">
                        <a href="/view-order-item/{{ $refNo }}" class="btn btn-warning"><i
                            class="fa fa-angle-left"></i>
                        Go Back</a>
                        <br/><br/>
                        <div class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Rate Checking</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Courier</th>
                                            <th>Courier Name</th>
                                            <th>Service Detail</th>
                                            <th>Price</th>
                                            <th>Pickup Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1 ?>
                                        @foreach ($ratesList as $value)
                                            <tr>
                                            <td>{{$index}}</td>
                                                <td>
                                                    <img style="width:80px;height:50px" class="img-responsive" src="{{ $value->courier_logo }}" /><br>
                                                </td>
                                                <td>
                                                    {{$value->courier_name}} <br>
                                                </td>
                                                <td>{{$value->service_detail}}</td>
                                                <td>
                                                    RM {{$value->shipment_price}}
                                                </td>
                                                <td>
                                                    {{$value->pickup_date}}
                                                </td>
                                                <td>
                                                <a class="btn btn-block bg-danger" href="add-to-cart-parcel/Shipping Price/{{$value->service_id}}/{{$value->shipment_price}}">Choose</a>
                                                </td>
                                            </tr>
                                            <?php $index++ ?>
                                        @endforeach
                                    </tbody>
                                </table>
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
