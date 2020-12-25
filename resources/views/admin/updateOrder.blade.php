@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Update Bulk Order</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Bulk Order</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
            <div class="row">
                <div style="margin: auto;" class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Update Orders</h3>

                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form action="{{url('update-order-awb')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Choose Orders <span style="color:yellow">  *</span></label>
                                            <select class="select2-width-50" style="width: 50%" name="refNo">
                                                <option value="as,"> Choose order </option>

                                                @foreach($pendingOrders as $order)
                                                    <option value="{{$order->orders_id}}" >{{$order->orders_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Charges <span style="color:yellow">  *</span></label>
                                            <input class="form-control" type="text" onkeypress="return isPriceKey(event)" name="price" placeholder="0.00" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Order No <span style="color:yellow">  *</span></label>
                                            <input class="form-control" type="text" onkeypress="return isNumberKey(event)"
                                             name="orderno" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tracking No <span style="color:yellow">  *</span></label>
                                            <input class="form-control" type="text"
                                             name="trackingNo" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Courier <span style="color:yellow">  *</span></label>
                                            <select class="select2-width-50" style="width: 50%" name="courier" required>
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
                                    <button type="submit" class="btn btn-block btn-warning">Update Order</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
       
    </div>
</div>


@endsection

@section('script')
<script>

</script>
@endsection
