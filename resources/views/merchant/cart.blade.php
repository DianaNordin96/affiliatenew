@extends('layouts.merchant')
@section('content')
@inject('customer', 'App\Http\Controllers\Merchant\CustomerController')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Payment Cart</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payment Cart</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <form action="{{ url('checkout-merchant') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div style="margin: auto;" class="col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h3 class="card-title">View Employee</h3> -->
                                    <a href="{{ url('product-merchant') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                        Continue Shopping</a><br /><br />
                                    <div style="text-align:center">
                                        <h3>Payment Cart</h3>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th width="50%"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $no = 1;
                                            
                                            $cartPayment = session('cartPayment');
                                            ?>

                                            @if (session('cartPayment'))
                                                @foreach ( $cartPayment as $key=>$value)
                                                <?php $getCustomer = $customer->getCustomer($key); ?>
                                                    <tr style="border-bottom: lightgrey  1px solid">
                                                        
                                                        <td style="padding-left:10px;text-align: right">
                                                            #{{ $no }}
                                                        </td>
                                                        <td>
                                                            Name: {{$getCustomer[0]->name}}<br/>
                                                        @foreach($cartPayment[$key][0] as $id => $details)
                                                            <?php $total += $details['price'] * $details['quantity']; ?>
                                                        
                                                                <div style="text-align: left">
                                                                    {{ $details['name'] }}<br />
                                                                    RM {{ $details['price'] }}<br/>
                                                                    Qty : {{$details['quantity']}}<br/>
                                                                    Subtotal = RM{{ number_format($details['price'] * $details['quantity'],2) }}
                                                                </div>
                                                                <br />
                                                        @endforeach
                                                        </td>
                                                        <td style="padding-left: 10%">
                                                            <div style="float: left">
                                                               
                                                                <a style="color:white" class="btn btn-danger btn-sm remove-from-cart"
                                                                    data-id="{{ $key }}"><i class="lni lni-trash"></i></a>
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
                                                    @if (session()->get('cartPayment') != null)
                                                        <button type="submit" id="checkout" class="btn btn-info">
                                                            Checkout
                                                            <i class="fa fa-angle-right"></i></button>
                                                    @endif
                                                </h4>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-5">
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
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Customer Name </label>
                                                        <input type="text" id="name" class="form-control" name="name"
                                                            placeholder="Name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Phone Number </label>
                                                        <input type="text" id="phone" class="form-control" name="phone"
                                                            placeholder="Phone Number" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Email </label>
                                                        <input type="text" id="email" class="form-control" name="email"
                                                            placeholder="Email" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #1</label>
                                                        <input type="text" id="address1" class="form-control"
                                                            name="address1" placeholder="" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #2 (Optional) </label>
                                                        <input type="text" id="address2" class="form-control"
                                                            name="address2" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Address #3 (Optional) </label>
                                                        <input type="text" id="address3" class="form-control"
                                                            name="address3" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" id="city" class="form-control" name="city"
                                                            placeholder="" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control select2bs4"  name="state">
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
                                                        <label>Postcode</label>
                                                        <input type="text" id="postcode" class="form-control" name="postcode"
                                                            placeholder="" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                            <strong>
                                                <h4>Total RM {{ number_format($total, 2) }} &nbsp; &nbsp;
                                                    @if (session()->get('cart') != null)
                                                        <button type="submit" id="checkout" class="btn btn-info">
                                                            Checkout
                                                            <i class="fa fa-angle-right"></i></button>
                                                    @endif
                                                </h4>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div> --}}
                    </div>
                </form>

    </div>
</div>
@endsection

@section('script')

    <script type="text/javascript">
        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart-payment-Merchant')}}',
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
