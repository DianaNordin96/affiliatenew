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
                    <h1>Update Orders (For Bulk Parcels)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                        <li class="breadcrumb-item active">Update Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div style="margin: auto;" class="col-lg-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Update Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form action="{{url('update-order-awb')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Choose Orders</label>
                                            <select class="form-control select2bs4" name="refNo">
                                                <option value="" hidden disabled selected> Choose order </option>
                                                @foreach($pendingOrders as $order)
                                                    <option value="{{$order->ordphers_id}}" >{{$order->orders_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Charges</label>
                                            <input class="form-control" type="text" name="price" placeholder="RM" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Order No *from parcel</label>
                                            <input class="form-control" type="text" name="orderno" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tracking No</label>
                                            <input class="form-control" type="text" name="trackingNo" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Courier</label>
                                            <select class="form-control" name="courier" required>
                                                <option value="Pgeon Delivery" selected>Pgeon Delivery</option>
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <button type="submit" class="btn btn-block bg-warning">Update Order</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
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
            //Initialize Select2 Elements
            $('.select2').select2()
    
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });


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

    document.getElementById("bulk-parcel").className = "nav-link active";
    document.getElementById("menuParcel").className = "nav-link active";
    document.getElementById("menuParcels").className = "nav-item menu-open has-treeview";
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

</script>
@endsection
