@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Bulk Messages</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Bulk Messages</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Credit Balance</h3>

                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div style="text-align: center" class="card-body">
                            <h3>CR {{ $creditBalance }} </h3>

                            <a target="_blank" href=" https://www.sms123.net/login.php" class="btn btn-block bg-danger">Top
                                Up</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Single SMS</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('singlesms-send') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Phone Number<span style="color:yellow">  *</span></label>
                                            <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                             name="phoneSingle"
                                                placeholder="Recipient Number" required />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Message<span style="color:yellow">  *</span></label>
                                            <textarea class="form-control" name="messageSingle" rows="3"
                                                placeholder="Message" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" style="width: 100%" class="btn btn-danger">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bulk SMS to all agent</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('bulksms-send-agent') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox mb-3">
											<input type="checkbox" class="custom-control-input" id="checkboxAgent">
											<label class="custom-control-label" for="checkboxAgent">Send to all agents</label>
                                        </div>
                                        <div id="autoUpdate2" class="autoUpdate2">
                                            <div class="form-group">
                                                <label>Agent's List<span style="color:yellow">  *</span></label>
                                                <select id="agents" class="multi-select" name="agents[]" multiple="multiple" required>
                                                    @foreach ($agentList as $value)
                                                        <option value="{{ $value->phone }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Message<span style="color:yellow">  *</span></label>
                                            <textarea class="form-control" name="messageAgent" rows="3"
                                                placeholder="Message" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-block bg-danger">Send Message</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bulk SMS to all customers</h3>

                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('bulksms-send-customer') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox mb-3">
											<input type="checkbox" class="custom-control-input" id="checkboxCustomer">
											<label class="custom-control-label" for="checkboxCustomer">Send to all customers</label>
                                        </div>
                                        <div id="autoUpdate" class="autoUpdate">
                                            <div class="form-group">
                                                <label>Customer's List<span style="color:yellow">  *</span></label>
                                                <select id="customers" class="multi-select" placeholder="Choose Customer" name="customers[]" multiple="multiple" required>
                                                    @foreach ($customerList as $value)
                                                        <option value="{{ $value->phone }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.form-group -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="messageCustomer" rows="3" placeholder="Message"
                                            required></textarea>
                                    </div>
                                </div>

                                <br />

                                <div class="row">
                                    <button type="submit" class="btn btn-block bg-danger">Send Message</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
       $(document).ready(function () {
            $('#checkboxCustomer').change(function () {
                if (!this.checked) 
                //  ^
                $('#autoUpdate').prop("hidden", false);
                else 
                    $('#autoUpdate').prop("hidden", true);
                    $('#customers option').prop('selected', true);
            });
        });

        $(document).ready(function () {
            $('#checkboxAgent').change(function () {
                if (!this.checked) 
                //  ^
                $('#autoUpdate2').prop("hidden", false);
                else 
                    $('#autoUpdate2').prop("hidden", true);
                    $('#agents option').prop('selected', true);
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
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

    </script>
@endsection
