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
                    {{-- <h1>Blast Message</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                        <li class="breadcrumb-item active">Parcel</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-8">
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
                        <div class="card-body">
                            {{-- <button class="btn btn-warning" onclick="exportTableToExcelComplete()">Export Order
                                List to
                                Excel</button>
                            <br /><br /> --}}
                            <table id="example2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="20%">Order No</th>
                                        <th>Customer Name</th>
                                        <th>Amount</th>
                                        <th>Courier</th>
                                        <th></th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cart = session()->get('cart');?>
                                    @foreach($consignment as $parcel)
                                        <tr>
                                            <td><a href="/view-order-item/{{$parcel->refNo}}">{{$parcel->refNo}}</a> <br/> {{ $parcel->order_number }}</td>
                                            <td>{{ $parcel->name }}</td>
                                            <td>RM {{ number_format($parcel->price,2) }}</td>
                                            <td>{{ $parcel->courier }}</td>
                                            <td>
                                                @if(isset($cart[$parcel->order_number]))
                                                <a style="color:white" href="/remove-cart-admin/{{$parcel->order_number}}" id="checkout" class="btn btn-info"><i class="fas fa-times"></i> Remove From Cart</a>
                                                @else
                                                <a style="color:white" href="/add-cart-admin/{{$parcel->order_number}}/{{$parcel->price}}" id="checkout" class="btn btn-info">Add To Cart</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
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
                            <h3>MYR {{ number_format($balance,2) }} </h3>
                            <a target="_blank" href="https://easyparcel.com/my/en/account/topup/"
                                class="btn btn-block bg-danger">Top Up</a>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    @if (session('cart'))
                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title"><b>Payment Details</b></h3>

                        </div> --}}
                        <!-- /.card-header -->
                        
                        <div id="cart" class="cart card-body">
                            <h4>Payment Details</h4>
                            <div class="row">
                                <?php $total=0 ?>
                            
                                <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Shipping Order No</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (session('cart') as $details)
                                            <tr>
                                            <td>{{$details['orderNo']}}</td>
                                            <td>RM {{number_format($details['price'],2)}}</td>
                                            </tr>
                                            <?php $total += $details['price']?>
                                            @endforeach
                                        </tbody>
                                </table>
                            
                            </div>

                            <div class="row">
                                <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                    <strong>
                                        <h4 style="color:red;float:left">Total : RM {{ number_format($total, 2) }}</h4>&nbsp;
                                            @if(session()->get('cart') != null)
                                            <a style="float:right" href="/checkout-admin" id="checkout" class="btn btn-info"> Checkout <i
                                                class="fa fa-angle-right"></i></a>
                                            @endif
                                        
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @endif
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
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    document.getElementById("parcel").className = "nav-link active";

</script>
@endsection
