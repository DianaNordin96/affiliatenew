@inject('customer', 'App\Http\Controllers\Admin\CustomerController')
@inject('parcel', 'App\Http\Controllers\Admin\ParcelController')
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
                        <?php $parcelDetails = session()->get('parcelDetails'); ?>
                        <a href="/view-order-item/{{$parcelDetails['refNo']}}" class="btn btn-warning"><i
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
                            <form id="formDetails" action="{{url('checkout-consignment')}}" method="POST">
                                @csrf
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
                                                @if($cart['shipping']['serv_id'] == $value->service_id)
                                                Courier Name : {{$value->courier_name}}
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select class="form-control select2bs4" style="width: 100%;" id="dropoff_point" name="dropoff_point" required>
                                                <option value="" hidden disabled selected> Choose dropoff point </option>
                                                @foreach($rateList->result[0]->rates as $key=>$value)
                                                    @if($cart['shipping']['serv_id'] == $value->service_id)
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
                                                    <input type="text" id="sender_name" class="form-control" name="sender_name"
                                                            placeholder="Sender Name" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Phone Number </label>
                                                        <input type="text" id="sender_phone" class="form-control" name="sender_phone"
                                                            placeholder="Phone Number" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #1</label>
                                                        <input type="text" id="sender_address1" class="form-control"
                                                            name="sender_address1" placeholder="" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #2 (Optional) </label>
                                                        <input type="text" id="sender_address2" class="form-control"
                                                            name="sender_address2" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Address #3 (Optional) </label>
                                                        <input type="text" id="sender_address3" class="form-control"
                                                            name="sender_address3" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" id="sender_city" class="form-control" name="sender_city"
                                                            placeholder="" required/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select id="sender_state" class="form-control select2bs4" name="sender_state" disabled>
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
                                                        <input type="text" id="sender_postcode" class="form-control" value="{{$sender['postcode']}}" name="sender_postcode"
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
                                $receiverDetails = $customer->getCustomer($parcelDetails['refNo']);
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
                                                    <input type="text" id="receiver_name" class="form-control" value="{{$receiverDetails[0]->name}}" name="receiver_name"
                                                            placeholder="Receiver Name" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Phone Number </label>
                                                        <input type="text" id="receiver_phone" class="form-control" value="{{$receiverDetails[0]->phone}}" name="receiver_phone"
                                                            placeholder="Phone Number" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #1</label>
                                                        <input type="text" id="receiver_address1" value="{{$receiverDetails[0]->address}}" class="form-control"
                                                            name="receiver_address1" placeholder="" readonly />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #2 (Optional) </label>
                                                        <input type="text" id="receiver_address2" value="{{$receiverDetails[0]->address_two}}" class="form-control"
                                                            name="receiver_address2" placeholder="" readonly/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Address #3 (Optional) </label>
                                                        <input type="text" id="receiver_address3" value="{{$receiverDetails[0]->address_three}}" class="form-control"
                                                            name="receiver_address3" placeholder="" readonly/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" id="receiver_city" class="form-control" value="{{$receiverDetails[0]->city}}" name="receiver_city"
                                                            placeholder="" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select id="receiver_state" class="form-control select2bs4" value="{{$receiverDetails[0]->state}}" name="receiver_state" disabled>
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
                                                        <input type="text" id="receiver_postcode" class="form-control" value="{{$receiverDetails[0]->postcode}}" name="receiver_postcode"
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
                            </form>

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
                                <h3 class="card-title"><b>Payment Details</b></h3>

                            </div>
                            <!-- /.card-header -->
                            
                            <div id="cart" class="cart card-body">
                                <h6 style="color:lightseagreen">Current Account Balance : RM {{number_format($parcel->checkBalance(),2)}}</h6>
                                <div class="row">
                                    <?php $total=0 ?>
                                @if (session('parcelCart'))
                                    <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Details</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (session('parcelCart') as $details)
                                                <tr>
                                                    <td>{{ $details['desc'] }}</td>
                                                    <td>RM {{ $details['price'] }}</td>
                                                </tr>
                                                
                                                <?php $total += $details['price']?>
                                                @endforeach
                                            </tbody>
                                    </table>
                                @endif
                                </div>

                                <div class="row">
                                    <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                        <strong>
                                            <h4 style="color:red;float:left">Total : RM {{ number_format($total, 2) }}</h4>&nbsp;
                                                @if(session()->get('parcelCart') != null)
                                                <button style="float:right" type="submit" onclick="checkout()" id="checkout" class="btn btn-info"> Checkout <i
                                                    class="fa fa-angle-right"></i></button>
                                                @endif
                                            
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

        function checkout(){

            var inputList = ["sender_name","sender_phone","sender_address1"];
            var i;
            var check = false;
            for (i = 0; i < inputList.length; i++) {
                var input = document.getElementById(inputList[i]).value;   

                if (input != ''){
                    check = true;
                }else{
                    check = false;
                }
            }

            if(check == true){
            document.getElementById('formDetails').submit();    
            }else{
               alert('Please enter sender details before submit page.');
            }
        }

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

