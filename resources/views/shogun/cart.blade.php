@extends('layouts.shogun')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cart</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            
                                @csrf
                                <div class="card-body">
                                    <!-- <h3 class="card-title">View Employee</h3> -->
                                    <div style="text-align:center">
                                        <h3>Shopping Cart</h3>
                                    </div>
                                <form action="{{ url('checkout') }}" method="POST">
                                    @csrf
                                    <div style="text-align:center">
                                        <select style=" margin-left: auto;margin-right: auto;width: 50%"
                                            class="form-control" name="customerID">
                                            <option value="" hidden> Choose Customer </option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br />
                                    <a href="{{ url('') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                        Continue Shopping</a>
                                    <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:50%">Product</th>
                                                <th style="width:10%">Price</th>
                                                <th style="width:8%">Quantity</th>
                                                <th style="width:22%" class="text-center">Subtotal</th>
                                                <th style="width:10%"></th>
                                            </tr>
                                        </thead>
                                        <?php $total = 0; ?>

                                        @if (session('cart'))
                                            @foreach (session('cart') as $id => $details)

                                                <?php $total += $details['price'] * $details['quantity']; ?>

                                                <tr>
                                                    <td data-th="Product">
                                                        <div class="row">
                                                            <div class="col-sm-3 hidden-xs"><img
                                                                    src="/imageUploaded/{{ $details['photo'] }}" width="100"
                                                                    height="100" class="img-responsive" /></div>
                                                            <div class="col-sm-9">
                                                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-th="Price">RM {{ $details['price'] }}</td>
                                                    <td data-th="Quantity">
                                                        <input type="number" value="{{ $details['quantity'] }}"
                                                            class="form-control quantity" />
                                                    </td>
                                                    <td data-th="Subtotal" class="text-center">
                                                        RM {{ $details['price'] * $details['quantity'] }}</td>
                                                    <td class="actions" data-th="">
                                                        <button class="btn btn-info btn-sm update-cart"
                                                            data-id="{{ $id }}"><i class="fas fa-sync-alt"></i></button>
                                                        <button class="btn btn-danger btn-sm remove-from-cart"
                                                            data-id="{{ $id }}"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </table>
                                    <br />
                                    <br />
                                    <div class="row">

                                        <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                            <strong>
                                                <h3>Total RM {{ number_format($total, 2) }} &nbsp; &nbsp;
                                                    <button type="submit" class="btn btn-info"> Checkout <i
                                                            class="fa fa-angle-right"></i></button></h3>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": false,
                "searching": false,
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
    <script type="text/javascript">
        $(".update-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('update-cartShogun') }}',
                method: "patch",
                data: {
                    _token: '{{csrf_token()}}',
                    id: ele.attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cartShogun ') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
@endsection
