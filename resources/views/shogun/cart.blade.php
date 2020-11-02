@extends('layouts.shogun')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cart</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('ShogunDashboard') }}">Dashboard</a>
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
                <form action="{{ url('checkout') }}" method="POST">
                    @csrf
                <div class="row">
                    
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-lg-12">
                                        <p>Choose existing cutomer :
                                            <select class="form-control" name="customerID">
                                                <option value="" hidden> Choose Customer </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="text-align:center" class="col-lg-12">
                                        <h3>OR</h3>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label> Customer Name </label>
                                                    <input type="text" id="name" class="form-control" name="name"
                                                        placeholder="Name" required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label> Phone Number </label>
                                                    <input type="text" id="phone" class="form-control" name="phone"
                                                        placeholder="Phone Number" required/>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address #1</label>
                                                    <input type="text" id="address1" class="form-control" name="address1"
                                                    placeholder="" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address #2 (Optional) </label>
                                                    <input type="text" id="address2" class="form-control" name="address2"
                                                    placeholder="" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Address #3 (Optional) </label>
                                                    <input type="text" id="address3" class="form-control" name="address3"
                                                    placeholder="" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8">
                        <div class="card">
                                <div class="card-body">
                                    <!-- <h3 class="card-title">View Employee</h3> -->
                                    <div style="text-align:center">
                                        <h3>Shopping Cart</h3>
                                    </div>
                                    
                                    <br />
                                    <a href="{{ url('') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                        Continue Shopping</a>
                                    <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:20%"></th>
                                                <th style="width:20%">Product</th>
                                                <th style="width:10%">Price</th>
                                                <th style="width:8%">Quantity</th>
                                                <th style="width:10%" class="text-center">Subtotal</th>
                                                <th style="width:10%"></th>
                                            </tr>
                                        </thead>
                                        <?php $total = 0; ?>

                                        @if (session('cart'))
                                            @foreach (session('cart') as $id => $details)

                                                <?php $total += $details['price'] * $details['quantity']; ?>

                                                <tr>
                                                    <td data-th="Product">
                                                       <img style="display: block;margin-left: auto;margin-right: auto;" src="/imageUploaded/{{ $details['photo'] }}" width="80" height="80" class="img-responsive" /></div>
                                                    </td>
                                                    <td>
                                                        {{ $details['name'] }}
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
                                                    @if(session()->get('cart') != null)
                                                    <button type="submit" id="checkout" class="btn btn-info"> Checkout <i
                                                        class="fa fa-angle-right"></i></button>
                                                    @endif
                                                   </h3>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                           </div>
                    </div>
                </div>
            </form>
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
                    url: '{{ url('remove-from-cartShogun') }}',
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
