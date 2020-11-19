@inject('customer', 'App\Http\Controllers\Admin\CustomerController')
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
                        <a href="/view-order-item/{{ session()->get('refNo') }}" class="btn btn-warning"><i
                            class="fa fa-angle-left"></i>
                        Cancel</a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                            <li class="breadcrumb-item active">Create Consignment</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-6">

                        <?php
                        $rateList = session()->get('rateList');
                        $cart = session()->get('parcelCart');
                        // dd($cart);
                        $sender = session()->get('senderDetails');

                        ?>

                        <div id="step1" class="card card-warning shadow">
                            <div class="card-header">
                                <h3 class="card-title">Dropoff Point</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        @foreach($rateList->result[0]->rates as $key=>$value)
                                            @if($cart['Shipping Price']['serv_id'] == $value->service_id)
                                            Courier Name : {{$value->courier_name}}
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select class="form-control select2bs4" style="width: 100%;" name="state">
                                            <option value="" hidden disabled selected> Choose dropoff point </option>
                                            @foreach($rateList->result[0]->rates as $key=>$value)
                                                @if($cart['Shipping Price']['serv_id'] == $value->service_id)
                                                    @foreach($rateList->result[0]->rates[$key]->dropoff_point as $dropPoint)
                                                        <option value="{{$dropPoint->point_id}}">{{$dropPoint->point_name}}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div id="step2" class="card card-warning collapsed-card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Sender Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
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
                                                    <label> Sender Name </label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                        placeholder="Name" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label> Phone Number </label>
                                                    <input type="text" id="phone" class="form-control" name="phone"
                                                        placeholder="Phone Number" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address #1</label>
                                                    <input type="text" id="address1" class="form-control"
                                                        name="address1" placeholder="" />
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
                                                        placeholder="" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select id="state" class="form-control select2bs4" name="state" disabled>
                                                        <option value="jhr" @if ($sender['state'] == 'jhr'){ selected @endif}>Johor</option>
                                                        <option value="kdh" @if ($sender['state'] == 'kdh'){ selected @endif}>Kedah</option>
                                                        <option value="ktn" @if ($sender['state'] == 'ktn'){ selected @endif}>Kelantan</option>
                                                        <option value="mlk" @if ($sender['state'] == 'mlk'){ selected @endif}>Melaka</option>
                                                        <option value="nsn" @if ($sender['state'] == 'nsn'){ selected @endif}>Negeri Sembilan </option>
                                                        <option value="phg" @if ($sender['state'] == 'phg'){ selected @endif}>Pahang</option>
                                                        <option value="prk" @if ($sender['state'] == 'prk'){ selected @endif}>Perak</option>
                                                        <option value="pls" @if ($sender['state'] == 'pls'){ selected @endif}>Perlis</option>
                                                        <option value="png" @if ($sender['state'] == 'png'){ selected @endif}>Pulau Pinang</option>
                                                        <option value="sgr" @if ($sender['state'] == 'sgr'){ selected @endif}>Selangor</option>
                                                        <option value="trg" @if ($sender['state'] == 'trg'){ selected @endif}>Terengganu</option>
                                                        <option value="kul" @if ($sender['state'] == 'kul'){ selected @endif}>Kuala Lumpur</option>
                                                        <option value="pjy" @if ($sender['state'] == 'pjy'){ selected @endif}>Putra Jaya</option>
                                                        <option value="srw" @if ($sender['state'] == 'srw'){ selected @endif}>Sarawak</option>
                                                        <option value="sbh" @if ($sender['state'] == 'sbh'){ selected @endif}>Sabah</option>
                                                        <option value="lbn" @if ($sender['state'] == 'lbn'){ selected @endif}>Labuan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Postcode</label>
                                                    <input type="text" id="postcode" class="form-control" value="{{$sender['postcode']}}" name="postcode"
                                                        placeholder="" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <?php 
                            $receiverDetails = $customer->getCustomer(session()->get('refNo'));
                        ?> 
                        <div id="step3" class="card card-warning shadow collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Receiver Details</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
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
                                                <input type="text" id="name" class="form-control" value="{{$receiverDetails[0]->name}}" name="name"
                                                        placeholder="Name" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label> Phone Number </label>
                                                    <input type="text" id="phone" class="form-control" value="{{$receiverDetails[0]->phone}}" name="phone"
                                                        placeholder="Phone Number" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address #1</label>
                                                    <input type="text" id="address1" value="{{$receiverDetails[0]->address}}" class="form-control"
                                                        name="address1" placeholder="" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Address #2 (Optional) </label>
                                                    <input type="text" id="address2" value="{{$receiverDetails[0]->address_two}}" class="form-control"
                                                        name="address2" placeholder="" readonly/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Address #3 (Optional) </label>
                                                    <input type="text" id="address3" value="{{$receiverDetails[0]->address_three}}" class="form-control"
                                                        name="address3" placeholder="" readonly/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" id="city" class="form-control" value="{{$receiverDetails[0]->city}}" name="city"
                                                        placeholder="" readonly />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select id="state" class="form-control select2bs4" value="{{$receiverDetails[0]->state}}" name="state" disabled>
                                                        <option value="jhr" @if ($receiverDetails[0]->state == 'jhr'){ selected @endif}>Johor</option>
                                                        <option value="kdh" @if ($receiverDetails[0]->state == 'kdh'){ selected @endif}>Kedah</option>
                                                        <option value="ktn" @if ($receiverDetails[0]->state == 'ktn'){ selected @endif}>Kelantan</option>
                                                        <option value="mlk" @if ($receiverDetails[0]->state == 'mlk'){ selected @endif}>Melaka</option>
                                                        <option value="nsn" @if ($receiverDetails[0]->state == 'nsn'){ selected @endif}>Negeri Sembilan </option>
                                                        <option value="phg" @if ($receiverDetails[0]->state == 'phg'){ selected @endif}>Pahang</option>
                                                        <option value="prk" @if ($receiverDetails[0]->state == 'prk'){ selected @endif}>Perak</option>
                                                        <option value="pls" @if ($receiverDetails[0]->state == 'pls'){ selected @endif}>Perlis</option>
                                                        <option value="png" @if ($receiverDetails[0]->state == 'png'){ selected @endif}>Pulau Pinang</option>
                                                        <option value="sgr" @if ($receiverDetails[0]->state == 'sgr'){ selected @endif}>Selangor</option>
                                                        <option value="trg" @if ($receiverDetails[0]->state == 'trg'){ selected @endif}>Terengganu</option>
                                                        <option value="kul" @if ($receiverDetails[0]->state == 'kul'){ selected @endif}>Kuala Lumpur</option>
                                                        <option value="pjy" @if ($receiverDetails[0]->state == 'pjy'){ selected @endif}>Putra Jaya</option>
                                                        <option value="srw" @if ($receiverDetails[0]->state == 'srw'){ selected @endif}>Sarawak</option>
                                                        <option value="sbh" @if ($receiverDetails[0]->state == 'sbh'){ selected @endif}>Sabah</option>
                                                        <option value="lbn" @if ($receiverDetails[0]->state == 'lbn'){ selected @endif}>Labuan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Postcode</label>
                                                    <input type="text" id="postcode" class="form-control" value="{{$receiverDetails[0]->postcode}}" name="postcode"
                                                        placeholder="" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div id="step4" class="step4 card card-warning shadow collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Additional Fees</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                        SMS Tracking (RM 0.20) : 
                                        @if(!isset($cart['sms']))
                                            <button class="btn btn-warning" type="button" onclick="addSMS()" id="addSMS">Add SMS Tracking</button>
                                        @else
                                            <button class="btn btn-danger" type="button" onclick="removeSMS()" id="removeSMS">Remove SMS Tracking</button>
                                        @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Payment Details</h3>

                            </div>
                            <!-- /.card-header -->
                            <div id="cart" class="cart card-body">
                                <?php $total=0 ?>
                                @if (session('parcelCart'))
                                     <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th> RM </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (session('parcelCart') as $details)
                                                <tr>
                                                    <td>{{ $details['desc'] }}</td>
                                                    <td>{{ $details['price'] }}</td>
                                                </tr>
                                                
                                                <?php $total += $details['price']?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                @endif

                                <br><br>

                                <div class="row">
                                    <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                        <strong>
                                            <h4>Total RM {{ number_format($total, 2) }} &nbsp; &nbsp;
                                                @if(session()->get('parcelCart') != null)
                                                <button type="submit" id="checkout" class="btn btn-info"> Checkout <i
                                                    class="fa fa-angle-right"></i></button>
                                                @endif
                                               </h4>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
        document.getElementById("blastMessage").className = "nav-link active";

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
    
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        function addSMS(){
        $.ajax({
                url: '{{ url('update-cart') }}',
                method: "patch",
                data: {
                    _token: '{{csrf_token()}}',
                },
                success: function(response) {
                    $.get(location.href).then(function(page) {
                        $("#cart").html($(page).find("#cart").html())
                        $("#step4").html($(page).find("#step4").html())
                    })
                }
            });
        }

        function removeSMS(){
            $.ajax({
                url: '{{ url('remove-cart') }}',
                method: "patch",
                data: {
                    _token: '{{csrf_token()}}',
                },
                success: function(response) {
                    $.get(location.href).then(function(page) {
                        $("#cart").html($(page).find("#cart").html())
                        $("#step4").html($(page).find("#step4").html())
                    })
                }
            });
        }
        

    </script>
@endsection

