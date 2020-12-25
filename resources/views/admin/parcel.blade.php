@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Parcels Payment</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Parcels Payment</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 order-md-2 mb-4">
                                    <?php $total = 0; ?>
                                        <h4>Credit Balance: MYR {{ number_format($balance, 2) }} </h4>
                                        <a target="_blank" href="https://easyparcel.com/my/en/account/topup/"
                                            class="btn btn-block btn-danger">Top Up</a>
                                    <br/>

                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Your cart</span>
                                        <span class="badge badge-primary badge-pill"> 
                                            @if (session('cart'))
                                                {{count(session('cart'))}}
                                            @else
                                            0
                                            @endif
                                        </span>
                                    </h4>
                                    @if (session('cart'))
                                    <ul class="list-group mb-3">
                                        @foreach (session('cart') as $details)
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <h6 class="my-0">{{ $details['orderNo'] }}</h6>
                                                {{-- <small class="text-muted">Brief description</small> --}}
                                            </div>
                                            <span class="text-muted">RM {{ number_format($details['price'], 2) }}</span>
                                        </li>
                                        <?php $total += $details['price']; ?>
                                       @endforeach
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Total (RM)</span>
                                            <strong>{{ number_format($total, 2) }}</strong>
                                        </li>
                                    </ul>
                                    @endif

                                    @if (session()->get('cart') != null)
                                        <a style="float:right" href="/checkout-admin" id="checkout"
                                            class="btn btn-info"> Checkout <i
                                                class="fa fa-angle-right"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-8 order-md-1">
                                    <h4 class="mb-3">Unpaid Consignment</h4>
                                    <button style="float:right" id="delete-button" class="btn btn-warning">Delete</button>
                                    <br /><br />
                                    <div class="table-responsive">
                                        <table id="examples2" class="table table-responsive-md">
                                            <thead>
                                                <tr>
                                                    <th style="width:50px;">
                                                        <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                                            <input type="checkbox" class="custom-control-input" id="checkAll"
                                                                required="">
                                                            <label class="custom-control-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th hidden></th>
                                                    <th width="20%">Order No</th>
                                                    <th>Customer Name</th>
                                                    <th>Amount</th>
                                                    <th>Courier</th>
                                                    <th></th>
                                                    {{-- <th>Actions</th>
                                                    --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $cart = session()->get('cart'); ?>
                                                @foreach ($consignment as $parcel)
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox checkbox-success check-lg mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                                <label class="custom-control-label" for="customCheckBox2"></label>
                                                            </div>
                                                        </td>
                                                        <td hidden>{{ $parcel->order_number }}</td>
                                                        <td aria-valuetext="{{ $parcel->refNo }}"><a
                                                                href="/view-order-item/{{ $parcel->refNo }}">{{ $parcel->refNo }}</a>
                                                            <br /> {{ $parcel->order_number }}</td>
                                                        <td>{{ $parcel->name }}</td>
                                                        <td>RM {{ number_format($parcel->price, 2) }}</td>
                                                        <td>{{ $parcel->courier }}</td>
                                                        <td>
                                                            @if (isset($cart[$parcel->order_number]))
                                                                <a style="color:white"
                                                                    href="/remove-cart-admin/{{ $parcel->order_number }}"
                                                                    id="checkout" class="btn btn-info"><i class="fas fa-times"></i>
                                                                    Remove From Cart</a>
                                                            @else
                                                                <a style="color:white"
                                                                    href="/add-cart-admin/{{ $parcel->order_number }}/{{ $parcel->price }}"
                                                                    id="checkout" class="btn btn-info">Add To Cart</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>


@endsection

@section('script')


    <script>
        // $("#checkAll").on("click", function() {
        //     if ($(this).is(':checked')) {
        //         $("#examples2 tr").each(function() {
        //             $(this).find("input").attr('checked', true);
        //         });
        //     } else {
        //         $("#examples2 tr").each(function() {
        //             $(this).find("input").attr('checked', false);
        //         });
        //     }
        // });

        $("#delete-button").on("click", function(e) {
            // $("#example2 tr:has(td > input[type=checkbox]:checked)").remove();
            e.preventDefault();
            // var message = "Id Name                  Country\n";
            var array = [];
            $("#examples2 input[type=checkbox]:checked").each(function() {
                var row = $(this).closest("tr")[0];
                var orderNo = row.cells[1].innerHTML;
                array.push(orderNo);
            });

            // alert(array);
            $.ajax({
                url: '{{ url('remove-consignment') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    orderNoList: array
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(function() {
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
        document.getElementById("menuParcel").className = "nav-link active";
        document.getElementById("menuParcels").className = "nav-item menu-open has-treeview";

    </script>
@endsection
