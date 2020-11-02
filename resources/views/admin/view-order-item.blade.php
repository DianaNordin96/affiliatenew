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
                    <h1>Purchase Item For {{ $referenceNo }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <div class="col-lg-5">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>

                            {{-- <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                              <i class="fas fa-times"></i>
                            </button>
                          </div> --}}
                        </div>
                        <div class="card-body">
                           @foreach($customerDetails as $customer)
                               <p><b>Name : {{$customer->name}}</b></p>
                               <p><b>Phone : {{$customer->phone}}</b></p>
                               <p><b>Address #1 : {{$customer->address}}</b></p>
                               <p><b>Address #2 : {{$customer->address_two}}</b></p>
                               <p><b>Address #3 : {{$customer->address_three}}</b></p>
                           @endforeach
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h3 class="card-title">View Employee</h3> -->
                            <a href="{{ url('/view-order') }}"
                                class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                Go Back</a>
                            <br /><br />


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price (RM) /each</th>
                                        <th>Quantity</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="col-sm-3 hidden-xs"><img
                                                        src="/imageUploaded/{{ $product->product_image }}" width="100"
                                                        height="100" class="img-responsive" /></div>
                                            </td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->price_shogun }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            {{-- <td>
                                                <a class="btn btn-warning" href="view-purchased-product/{{ $orderDetail->orders_id }}"><i
                                                class="far fa-eye"></i>&nbsp; View item</a> &nbsp;
                                            </td> --}}
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

    document.getElementById("view-order").className = "nav-link active";

</script>
@endsection
