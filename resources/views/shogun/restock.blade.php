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

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Customers</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div id="accordion-two" class="accordion accordion-danger-solid">
                                <div class="accordion__item">
                                    <div class="accordion__header" data-toggle="collapse"
                                        data-target="#bordered_collapseOne"> <span
                                            class="accordion__header--text">Products</span>
                                        <span class="accordion__header--indicator"></span>
                                    </div>
                                    <div id="bordered_collapseOne" class="collapse accordion__body show"
                                        data-parent="#accordion-two">
                                        <div class="accordion__body--text">
                                            <div class="col-xl-12 col-md-12 col-sm-12">
                                                <div class="basic-list-group">
                                                    <div class="list-group">

                                                        @foreach ($products as $product)
                                                            <li href="javascript:void()"
                                                                class="list-group-item list-group-item-action flex-column align-items-start">
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <span class="mb-3"></span>
                                                                    <span class="text-muted">RM
                                                                        {{ number_format($product->price_hq, 2) }}</span>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-4 col-sm-12 col-md-5">
                                                                        <img class="img-fluid"
                                                                        style="display: block; margin-left: auto; margin-right: auto;" width="150px" height="150px"
                                                                            {{--
                                                                            src="../imageUploaded/products/{{ $product->product_image }}"
                                                                            --}}
                                                                            src="{{ asset('imageUploaded/popcorn_PNG56.png') }}" />
                                                                    </div>

                                                                    <div class="col-lg-4 col-sm-12 col-md-5">

                                                                        <h6>{{ $product->product_name }}</h6>
                                                                        <br>
                                                                        {{ $product->product_description }}
                                                                        <br>
                                                                        Commission: RM
                                                                        {{ number_format($product->product_price - $product->price_hq, 2) }}
                                                                        /each
                                                                        <br><br>

                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-9 col-sm-12">
                                                                        <button type="button"
                                                                            class="btn btn-block btn-success"
                                                                            onclick="window.location='{{ url('addToCartShogun/' . $product->id) }}'">
                                                                            Add to cart</button>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <button style="color:white;width:100%" type="button" title="View"
                                                                            data-toggle="modal" onclick="openModalView(
                                                                                            '{{ $product->product_image }}',
                                                                                            '{{ $product->product_name }}',
                                                                                            '{{ $product->product_description }}',
                                                                                            '{{ number_format($product->price_hq, 2) }}',
                                                                                            '{{ number_format($product->product_price - $product->price_hq, 2) }}',
                                                                                            '{{ $product->product_link }}'
                                                                                            )"
                                                                            data-target="#modalView"
                                                                            class="btn btn-warning"><i
                                                                                class="lni lni-eye"></i></button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div id="accordion-two" class="accordion accordion-danger-solid">
                                <div class="accordion__item">
                                    <div class="accordion__header" data-toggle="collapse"
                                        data-target="#bordered_collapseTwo"> <span
                                            class="accordion__header--text">Cart</span>
                                        <span class="accordion__header--indicator"></span>
                                    </div>
                                    <div id="bordered_collapseTwo" class="collapse accordion__body show"
                                        data-parent="#accordion-two">
                                        <div class="accordion__body--text">
                                            <div style="text-align:center">
                                                <h3>Shopping Cart</h3>
                                            </div>

                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th width="50%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total = 0;
                                                    $no = 1;
                                                    ?>

                                                    @if (session('cart'))
                                                        @foreach (session('cart') as $id => $details)
                                                            <?php $total += $details['price'] * $details['quantity']; ?>

                                                            <tr style="border-bottom: lightgrey  1px solid">
                                                                <td style="padding-left:10px;text-align: right">
                                                                    #{{ $no }}
                                                                </td>
                                                                <td>
                                                                    <br />
                                                                    <img style="display: block;margin-left: auto;margin-right: auto;"
                                                                        src="../imageUploaded/products/{{ $details['photo'] }}"
                                                                        width="30" height="30" class="img-responsive" />
                                                                    <br />
                                                                    <div style="text-align: center">
                                                                        {{ $details['name'] }}<br />
                                                                        RM {{ $details['price'] }}/each
                                                                    </div>
                                                                    <br />
                                                                </td>
                                                                <td style="padding-left: 10%">
                                                                    <div style="float: right">
                                                                        Subtotal: RM
                                                                        {{ $details['price'] * $details['quantity'] }}<br /><br />
                                                                        <input type="number" value="{{ $details['quantity'] }}"
                                                                            style="width:60%" class="form-control quantity" /><br />
                                                                        <a style="color:white" class="btn btn-info btn-sm update-cart"
                                                                            data-id="{{ $id }}"><i class="lni lni-reload"></i></a>
                                                                        &nbsp;&nbsp;
                                                                        <a style="color:white" class="btn btn-danger btn-sm remove-from-cart"
                                                                            data-id="{{ $id }}"><i class="lni lni-trash"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php $no++; ?>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                                    <br>
                                                    <strong>
                                                        <h4>Total RM {{ number_format($total, 2) }} &nbsp; &nbsp;
                                                            @if (session()->get('cart') != null)
                                                                <button type="submit" id="checkout" data-toggle="modal"
                                                                    data-target="#modal-lg" class="btn btn-info">
                                                                    Add to payment cart
                                                                    <i class="fa fa-angle-right"></i></button>
                                                            @endif
                                                        </h4>
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Customer Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('addToPaymentCart-shogun') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Customer Name <span style="color:yellow">  *</span>
                                            </label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Name" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Phone Number <span style="color:yellow">  *</span>
                                            </label>
                                            <input type="text" id="phone" class="form-control" name="phone"
                                                placeholder="Phone Number" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Address #1 <span style="color:yellow">  *</span>
                                            </label>
                                            <input type="text" id="address1" class="form-control" name="address1"
                                                placeholder="" required />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Email </label>
                                            <input type="text" id="email" class="form-control" name="email"
                                                placeholder="Email" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Address #2 (Optional) </label>
                                            <input type="text" id="address2" class="form-control" name="address2"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Address #3 (Optional) </label>
                                            <input type="text" id="address3" class="form-control" name="address3"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>City <span style="color:yellow">  *</span>
                                            </label>
                                            <input type="text" id="city" class="form-control" name="city" placeholder=""
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>State <span style="color:yellow">  *</span>
                                            </label>
                                            <select class="select2-width-75" style="width: 75%" style="width: 100%;" name="state">
                                                <option value="jhr">Johor</option>
                                                <option value="kdh">Kedah</option>
                                                <option value="ktn">Kelantan</option>
                                                <option value="mlk">Melaka</option>
                                                <option value="nsn">Negeri Sembilan </option>
                                                <option value="phg">Pahang</option>
                                                <option value="prk">Perak</option>
                                                <option value="pls">Perlis</option>
                                                <option value="png">Pulau Pinang</option>
                                                <option value="sgr">Selangor</option>
                                                <option value="trg">Terengganu</option>
                                                <option value="kul">Kuala Lumpur</option>
                                                <option value="pjy">Putra Jaya</option>
                                                <option value="srw">Sarawak</option>
                                                <option value="sbh">Sabah</option>
                                                <option value="lbn">Labuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Postcode <span style="color:yellow">  *</span>
                                            </label>
                                            <input type="text" id="postcode" class="form-control" name="postcode"
                                                placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> Add to payment cart </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

    <div class="modal fade" id="modalView">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewEmpName"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-view">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection

@section('script')


    <script type="text/javascript">
        $(".update-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('update-cartShogun') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
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
                        _token: '{{ csrf_token() }}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });

        document.getElementById("products").className = "nav-link active";

        function openModalView(prodImage, prodName, prodDesc, prodActualPrice, prodComm, link) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<img style='display: block; margin-left: auto; margin-right: auto;' width='150px' height='150px' src='../imageUploaded/products/" +
                prodImage + "'/>" +
                "</div>" +
                "<div class='col-sm-6'>" +
                "<b>Product Name  </b> : " + prodName + "<br/>" +
                "<b>Description  </b> : " + prodDesc + "<br/>" +
                "<b>Product Price  </b> : RM " + prodActualPrice + "<br/>" +
                "<b>Commission </b> : RM " + prodComm + "<br/>" +
                "<b>Product Link: </b><a href=" + link + ">" + link + "</a><br/>" +
                "</div>" +
                "</div>";
        }

    </script>
@endsection
