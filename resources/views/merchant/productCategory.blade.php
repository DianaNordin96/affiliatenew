@inject('category', 'App\Http\Controllers\Merchant\ManageStockController')
@extends('layouts.merchant')
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
                    <h4>Product Category</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Category</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                <button type="button" title="View" data-toggle="modal"  data-target="#modalCart" class="btn btn-success">Cart &nbsp;
                    <span class="badge badge-primary badge-pill">
                        @if (session('cart') != null)
                        {{ count(session('cart')) }}
                        @else
                            0
                        @endif
                    </span>
                </button>
                <br><br>
            </div>
        </div>
        <div class="row">
                @foreach ($productsCategory as $cat)
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid"
                                        style="width:220px;height:250px; display: block; margin-left: auto; margin-right: auto;" 
                                            src="{{asset('imageUploaded/productCat/'.$cat->image.'')}}" />
                                    </div>
                                    <div class="new-arrival-content text-center mt-3">
                                        <h4>{{ $cat->category }}</h4>
                                        <span class="price"><h6>{{ $cat->desc }}</h6></span>
                                    </div>
                                    <div class="row">
                                        <div style="margin: auto"><button style="color:white;" type="button" title="View"
                                                data-toggle="modal" onclick="location='/product-merchant/{{$cat->category}}/{{ $cat->id }}'" class="btn btn-warning">View Products</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>
</div>

<div class="modal fade" id="modalCart">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Shopping Cart</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body-view">
                <div class="row">
                    <div class="col-lg-12">
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
                                                src="{{asset('imageUploaded/products/'.$details['photo'].'')}}" 
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
                                            <button type="submit" data-dismiss="modal" id="checkout" data-toggle="modal"
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
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                <form action="{{ url('addToPaymentCart-merchant') }}" method="post" enctype="multipart/form-data">
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
                                        <label> Notes </label>
                                        <textarea type="text" id="notes" class="form-control" name="notes" rows="3"></textarea>
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
                                        <input type="text" id="postcode" onkeyup="number(event);" onkeypress="return isNumberKey(event)" class="form-control" name="postcode"
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

@endsection

@section('script')
<script type="text/javascript">
    $(".update-cart").click(function(e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ url('update-cartMerchant') }}',
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
                url: '{{ url('remove-from-cartMerchant') }}',
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
</script>
@endsection
