@inject('customer', 'App\Http\Controllers\Admin\CustomerController')
@inject('parcel', 'App\Http\Controllers\Admin\ParcelController')
@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <?php $parcelDetails = session()->get('parcelDetails'); ?>
                        <a href="/view-order-item/{{ $parcelDetails['refNo'] }}" class="btn btn-warning"><i
                                class="fa fa-angle-left"></i>
                            Cancel</a>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Consignment</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-md-6">
                    <?php
                    $rateList = session()->get('rateList');
                    $cart = session()->get('parcelCart');
                    // dd($cart);
                    $sender = session()->get('senderDetails');
                    ?>
                    <div class="card">
                        <div class="card-header d-block">
                            <h4 class="card-title">Consignment Details</h4>
                        </div>
                        <div class="card-body">
                            <div id="accordion-two" class="accordion accordion-danger-solid">
                                <form id="formDetails" action="{{ url('checkout-consignment') }}" method="POST">
                                    @csrf
                                    <div class="accordion__item">
                                        <div class="accordion__header" data-toggle="collapse"
                                            data-target="#bordered_collapseOne"> <span
                                                class="accordion__header--text">Dropoff Point</span>
                                            <span class="accordion__header--indicator"></span>
                                        </div>
                                        <div id="bordered_collapseOne" class="collapse accordion__body show"
                                            data-parent="#accordion-two">
                                            <div class="accordion__body--text">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        @foreach ($rateList->result[0]->rates as $key => $value)
                                                            @if ($cart['shipping']['serv_id'] == $value->service_id)
                                                                Courier Name : {{ $value->courier_name }}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <select class="select2-width-75" style="width: 75%" style="width: 100%;"
                                                            id="dropoff_point" name="dropoff_point" required>
                                                            <option value="" hidden selected> Choose dropoff point </option>
                                                            <option value=""> Pickup (Select this for pickup service)
                                                            </option>
                                                            @foreach ($rateList->result[0]->rates as $key => $value)
                                                                @if ($cart['shipping']['serv_id'] == $value->service_id)
                                                                    @foreach ($rateList->result[0]->rates[$key]->dropoff_point as $dropPoint)
                                                                        <option value="{{ $dropPoint->point_id }}">
                                                                            {{ $dropPoint->point_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion__item">
                                        <div class="accordion__header collapsed" data-toggle="collapse"
                                            data-target="#bordered_collapseTwo"> <span
                                                class="accordion__header--text">Sender Details</span>
                                            <span class="accordion__header--indicator"></span>
                                        </div>
                                        <div id="bordered_collapseTwo" class="collapse accordion__body"
                                            data-parent="#accordion-two">
                                            <div class="accordion__body--text">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label> Sender Name <span style="color:yellow">  *</span></label>
                                                                    <input type="text" id="sender_name" class="form-control"
                                                                        name="sender_name" onkeypress="return isAlphabetsKey(event)"
                                                                         placeholder="Sender Name"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label> Phone Number <span style="color:yellow">  *</span></label>
                                                                    <input type="text" id="sender_phone" onkeypress="return isNumberKey(event)"
                                                                        class="form-control" name="sender_phone"
                                                                        placeholder="Phone Number" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Address #1 <span style="color:yellow">  *</span></label>
                                                                    <input type="text" id="sender_address1"
                                                                        class="form-control" name="sender_address1"
                                                                        placeholder="" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Address #2 (Optional) </label>
                                                                    <input type="text" id="sender_address2"
                                                                        class="form-control" name="sender_address2"
                                                                        placeholder="" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Address #3 (Optional) </label>
                                                                    <input type="text" id="sender_address3"
                                                                        class="form-control" name="sender_address3"
                                                                        placeholder="" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>City <span style="color:yellow">  *</span></label>
                                                                    <input type="text" id="sender_city" class="form-control"
                                                                        name="sender_city" placeholder="" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>State</label>
                                                                    <select id="sender_state"
                                                                        class="form-control select2bs4" name="sender_state"
                                                                        disabled>
                                                                        <option value="jhr" @if ($sender['state'] == 'jhr'){ selected
                                                                            @endif}>Johor</option>
                                                                        <option value="kdh" @if ($sender['state'] == 'kdh'){ selected
                                                                            @endif}>Kedah</option>
                                                                        <option value="ktn" @if ($sender['state'] == 'ktn'){ selected
                                                                            @endif}>Kelantan</option>
                                                                        <option value="mlk" @if ($sender['state'] == 'mlk'){ selected
                                                                            @endif}>Melaka</option>
                                                                        <option value="nsn" @if ($sender['state'] == 'nsn'){ selected
                                                                            @endif}>Negeri Sembilan
                                                                        </option>
                                                                        <option value="phg" @if ($sender['state'] == 'phg'){ selected
                                                                            @endif}>Pahang</option>
                                                                        <option value="prk" @if ($sender['state'] == 'prk'){ selected
                                                                            @endif}>Perak</option>
                                                                        <option value="pls" @if ($sender['state'] == 'pls'){ selected
                                                                            @endif}>Perlis</option>
                                                                        <option value="png" @if ($sender['state'] == 'png'){ selected
                                                                            @endif}>Pulau Pinang
                                                                        </option>
                                                                        <option value="sgr" @if ($sender['state'] == 'sgr'){ selected
                                                                            @endif}>Selangor</option>
                                                                        <option value="trg" @if ($sender['state'] == 'trg'){ selected
                                                                            @endif}>Terengganu</option>
                                                                        <option value="kul" @if ($sender['state'] == 'kul'){ selected
                                                                            @endif}>Kuala Lumpur
                                                                        </option>
                                                                        <option value="pjy" @if ($sender['state'] == 'pjy'){ selected
                                                                            @endif}>Putra Jaya</option>
                                                                        <option value="srw" @if ($sender['state'] == 'srw'){ selected
                                                                            @endif}>Sarawak</option>
                                                                        <option value="sbh" @if ($sender['state'] == 'sbh'){ selected
                                                                            @endif}>Sabah</option>
                                                                        <option value="lbn" @if ($sender['state'] == 'lbn'){ selected
                                                                            @endif}>Labuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Postcode</label>
                                                                    <input type="text" id="sender_postcode"
                                                                        class="form-control"
                                                                        value="{{ $sender['postcode'] }}"
                                                                        name="sender_postcode" placeholder="" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion__item">
                                        <div class="accordion__header collapsed" data-toggle="collapse"
                                            data-target="#bordered_collapseThree"> <span
                                                class="accordion__header--text">Receiver Details</span>
                                            <span class="accordion__header--indicator"></span>
                                        </div>
                                        <?php $receiverDetails =
                                        $customer->getCustomer($parcelDetails['refNo']); ?>
                                        <div id="bordered_collapseThree" class="collapse accordion__body"
                                            data-parent="#accordion-two">
                                            <div class="accordion__body--text">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label> Customer Name </label>
                                                                    <input type="text" id="receiver_name"
                                                                        class="form-control"
                                                                        value="{{ $receiverDetails[0]->name }}"
                                                                        name="receiver_name" placeholder="Receiver Name"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- text input -->
                                                                <div class="form-group">
                                                                    <label> Phone Number </label>
                                                                    <input type="text" id="receiver_phone"
                                                                        class="form-control"
                                                                        value="{{ $receiverDetails[0]->phone }}"
                                                                        name="receiver_phone" placeholder="Phone Number"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Address #1</label>
                                                                    <input type="text" id="receiver_address1"
                                                                        value="{{ $receiverDetails[0]->address }}"
                                                                        class="form-control" name="receiver_address1"
                                                                        placeholder="" readonly />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Address #2 (Optional) </label>
                                                                    <input type="text" id="receiver_address2"
                                                                        value="{{ $receiverDetails[0]->address_two }}"
                                                                        class="form-control" name="receiver_address2"
                                                                        placeholder="" readonly />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Address #3 (Optional) </label>
                                                                    <input type="text" id="receiver_address3"
                                                                        value="{{ $receiverDetails[0]->address_three }}"
                                                                        class="form-control" name="receiver_address3"
                                                                        placeholder="" readonly />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>City</label>
                                                                    <input type="text" id="receiver_city"
                                                                        class="form-control"
                                                                        value="{{ $receiverDetails[0]->city }}"
                                                                        name="receiver_city" placeholder="" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>State</label>
                                                                    <select id="receiver_state"
                                                                        class="form-control select2bs4"
                                                                        value="{{ $receiverDetails[0]->state }}"
                                                                        name="receiver_state" disabled>
                                                                        <option value="jhr" @if ($receiverDetails[0]->state == 'jhr')
                                                                            { selected @endif}>Johor
                                                                        </option>
                                                                        <option value="kdh" @if ($receiverDetails[0]->state == 'kdh')
                                                                            { selected @endif}>Kedah
                                                                        </option>
                                                                        <option value="ktn" @if ($receiverDetails[0]->state == 'ktn')
                                                                            { selected @endif}>Kelantan
                                                                        </option>
                                                                        <option value="mlk" @if ($receiverDetails[0]->state == 'mlk')
                                                                            { selected @endif}>Melaka
                                                                        </option>
                                                                        <option value="nsn" @if ($receiverDetails[0]->state == 'nsn')
                                                                            { selected @endif}>Negeri
                                                                            Sembilan </option>
                                                                        <option value="phg" @if ($receiverDetails[0]->state == 'phg')
                                                                            { selected @endif}>Pahang
                                                                        </option>
                                                                        <option value="prk" @if ($receiverDetails[0]->state == 'prk')
                                                                            { selected @endif}>Perak
                                                                        </option>
                                                                        <option value="pls" @if ($receiverDetails[0]->state == 'pls')
                                                                            { selected @endif}>Perlis
                                                                        </option>
                                                                        <option value="png" @if ($receiverDetails[0]->state == 'png')
                                                                            { selected @endif}>Pulau
                                                                            Pinang</option>
                                                                        <option value="sgr" @if ($receiverDetails[0]->state == 'sgr')
                                                                            { selected @endif}>Selangor
                                                                        </option>
                                                                        <option value="trg" @if ($receiverDetails[0]->state == 'trg')
                                                                            { selected @endif
                                                                            }>Terengganu</option>
                                                                        <option value="kul" @if ($receiverDetails[0]->state == 'kul')
                                                                            { selected @endif}>Kuala
                                                                            Lumpur</option>
                                                                        <option value="pjy" @if ($receiverDetails[0]->state == 'pjy')
                                                                            { selected @endif}>Putra
                                                                            Jaya</option>
                                                                        <option value="srw" @if ($receiverDetails[0]->state == 'srw')
                                                                            { selected @endif}>Sarawak
                                                                        </option>
                                                                        <option value="sbh" @if ($receiverDetails[0]->state == 'sbh')
                                                                            { selected @endif}>Sabah
                                                                        </option>
                                                                        <option value="lbn" @if ($receiverDetails[0]->state == 'lbn')
                                                                            { selected @endif}>Labuan
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Postcode</label>
                                                                    <input type="text" id="receiver_postcode"
                                                                        class="form-control"
                                                                        value="{{ $receiverDetails[0]->postcode }}"
                                                                        name="receiver_postcode" placeholder="" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="accordion__item">
                                    <div class="accordion__header collapsed" data-toggle="collapse"
                                        data-target="#bordered_collapseFour"> <span
                                            class="accordion__header--text">Additional Fees</span>
                                        <span class="accordion__header--indicator"></span>
                                    </div>
                                    <div id="bordered_collapseFour" class="collapse accordion__body"
                                        data-parent="#accordion-two">
                                        <div class="accordion__body--text">
                                            <div id="step4" class="form-group">
                                                SMS Tracking (RM 0.20) :
                                                @if (!isset($cart['sms']))
                                                    <button class="btn btn-warning" type="button" onclick="addSMS()"
                                                        id="addSMS">Add SMS Tracking</button>
                                                @else
                                                    <button class="btn btn-danger" type="button" onclick="removeSMS()"
                                                        id="removeSMS">Remove SMS Tracking</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>Payment Details</b></h3>

                        </div>
                        <!-- /.card-header -->

                        <div id="cart" class="cart card-body">
                            <h6 style="color:lightseagreen">Current Account Balance : RM
                                {{ number_format($parcel->checkBalance(), 2) }}</h6>
                            <div class="row">
                                <?php $total = 0; ?>
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

                                                <?php $total += $details['price']; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="row">
                                <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                    <strong>
                                        <h4 style="color:red;float:left">Total : RM {{ number_format($total, 2) }}</h4>
                                        &nbsp;
                                        @if (session()->get('parcelCart') != null)
                                            <button style="float:right" type="submit" onclick="checkout()" id="checkout"
                                                class="btn btn-info"> Add to Unpaid Consignment <i
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
        </div>
    </div>


@endsection

@section('script')
    <script>
        document.getElementById("blastMessage").className = "nav-link active";

        function checkout() {

            var inputList = ["sender_name", "sender_phone", "sender_address1"];
            var i;
            var check = false;
            for (i = 0; i < inputList.length; i++) {
                var input = document.getElementById(inputList[i]).value;

                if (input != '') {
                    check = true;
                } else {
                    check = false;
                }
            }

            if (check == true) {
                document.getElementById('formDetails').submit();
            } else {
                alert('Please enter sender details before submit page.');
            }
        }

        function addSMS() {
            $.ajax({
                url: '{{url('update-cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $.get(location.href).then(function(page) {
                        $("#cart").html($(page).find("#cart").html())
                        $("#step4").html($(page).find("#step4").html())
                    })
                }
            });
        }

        function removeSMS() {
            $.ajax({
                url: '{{ url('remove-cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
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
