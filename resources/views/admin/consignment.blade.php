@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Choose Courier</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Consignment</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-md-12">
                    <a href="/view-order-item/{{ $refNo }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                        Go Back</a>
                    <br /><br />
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rate Checking</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pb-0 px-4 pt-4">
                            <div style="overflow-y:auto;height:400px" class="table-responsive">
                                <table class="table table-hover table-responsive-sm">
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
                                        <?php $index = 1; ?>
                                        @foreach ($ratesList as $value)
                                            <tr>
                                                <td>{{ $index }}</td>
                                                <td>
                                                    <img style="width:80px;height:50px" class="img-responsive"
                                                        src="{{ $value->courier_logo }}" /><br>
                                                </td>
                                                <td>
                                                    {{ $value->courier_name }} <br>
                                                </td>
                                                <td>{{ $value->service_detail }}</td>
                                                <td>
                                                    RM {{ $value->shipment_price }}
                                                </td>
                                                <td>
                                                    {{ $value->pickup_date }}
                                                </td>
                                                <td>
                                                    <a style="color:white" class="btn btn-danger"
                                                        href="add-to-cart-parcel/Shipping Price/{{ $value->service_id }}/{{ $value->shipment_price }}">Choose</a>
                                                </td>
                                            </tr>
                                            <?php $index++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
@endsection
