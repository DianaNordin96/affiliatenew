@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Agents</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
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
            </div>

            <div class="row">
                <div class="col-lg-4">
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
                                            <label> Phone Number </label>
                                            <input type="text" class="form-control" name="phoneSingle"
                                                placeholder="Recipient Number" required />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Message </label>
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

                <div class="col-lg-4">
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
                                        <div class="form-group">
                                            <label>Agent's List</label>
                                            <select class="duallistbox" name="agents[]" multiple="multiple" required>
                                                @foreach ($agentList as $value)
                                                    <option value="{{ $value->phone }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Message </label>
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

                <div class="col-lg-4">
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
                                        <div class="form-group">
                                            <label>Customer's List</label>
                                            <select class="duallistbox" name="customers[]" multiple="multiple" required>
                                                @foreach ($customerList as $value)
                                                    <option value="{{ $value->phone }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
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
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

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
