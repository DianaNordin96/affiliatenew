@extends('layouts.shogun')
@section('content')

@section('headScript')
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #2196F3;
            padding: 10px;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
        }

    </style>
@endsection

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row d-flex align-items-stretch">
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        @foreach ($products as $product)
                            <div class="card bg-light">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <br />
                                            <img style="display: block;margin-left: auto;margin-right: auto;width: 50%;"
                                                class="img-square img-fluid" width="60%" height="80%"
                                                src="/imageUploaded/{{ $product->product_image }}" />
                                            <br />

                                            <div style="text-align:center">
                                                {{ $product->product_name }}
                                                <br />
                                                {{ $product->product_description }}
                                                <br />
                                                <b>RM {{ $product->product_price }}</b>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <br />
                                            <button type="button" class="btn btn-block btn-outline-info" onclick="window.location='{{ url('addToCartShogun/'.$product->id) }}'"> Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card-footer">
                                    <div class="text-center">
                                        {{-- <a href="#" class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments"></i>
                                        </a> --}}
                                        {{-- <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> Add To Cart
                                        </a>
                                    </div>
                                </div> --}} 
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    document.getElementById("customerDetails").className = "nav-link active";

</script>
@endsection