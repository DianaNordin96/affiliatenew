@inject('tracking', 'App\Http\Controllers\Damio\PurchaseController')
@inject('order', 'App\Http\Controllers\Damio\PurchaseController')
@extends('layouts.damio')
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
                        <h1>Purchase History</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('DamioDashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Purchase History</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Orders ID</th>
                                            <th>Bill Code</th>
                                            <th>Amount (RM)</th>
                                            <th>Purchased At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            {{-- <th>View Receipt</th>
                                            --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_detail as $orderDetail)
                                            <tr>
                                                <td>{{ $orderDetail->orders_id }}</td>
                                                <td>{{ $orderDetail->bill_code }}</td>
                                                <td>{{ number_format($orderDetail->amount, 2) }}</td>
                                                <td>{{ $orderDetail->created_at }}</td>
                                                <td>

                                                    <?php $consignmentArray = $order->checkOrderExistConsignment($orderDetail->orders_id); ?>
                                                    @if(count($consignmentArray) != 0 && $consignmentArray[0]->awb != NULL )
                                                    <?php $trackingStatus = $tracking->getTrackingStatus($consignmentArray[0]->awb);?>
                                                    @foreach($trackingStatus->result as $value)
                                                        Latest Status : {{$value->latest_status}}<br/>
                                                    @endforeach
                                                    @else
                                                    <h6 style="color: red">Order not yet packed.</h6>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="/view-purchased-product-damio/{{ $orderDetail->orders_id }}"><i
                                                            class="far fa-eye"></i>&nbsp; View item</a> &nbsp;
                                                </td>
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
        $(function() {
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

        document.getElementById("history").className = "nav-link active";

    </script>
@endsection
