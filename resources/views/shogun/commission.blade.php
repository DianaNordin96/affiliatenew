@extends('layouts.shogun')
@section('headScript')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Commission</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Commission</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Total Commission</h3>
                            </div>
                            <!-- /.card-header -->
                            <div style="text-align: center" class="card-body">
                                <h3>RM @foreach ($commissionPoint as $value)
                                        {{ $value->commissionPoint }}
                                    @endforeach </h3>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Request for withdrawal</h3>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('commission-shogun-withdrawal') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Amount To Withdraw <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="amount" class="form-control" name="amount" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                                    placeholder="Amount to withdraw" required />
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- text input -->

                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Bank Name <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="bank" class="form-control" name="bank" onkeyup="alphabets(event);" onkeypress="return isAlphabetsKey(event)"
                                                    placeholder="Bank Name" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Account No. <span style="color:yellow">  *</span>
                                                </label>
                                                <input type="text" id="accountNo" onkeyup="number(event);" onkeypress="return isNumberKey(event)"
                                                class="form-control" name="accountNo"
                                                    placeholder="Account Number" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-block btn-danger">Request for
                                                Withdrawal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Withdrawal Request History</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example5" class="display">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount Withdraw</th>
                                            <th>Before Deducted</th>
                                            <th>After Deducted</th>
                                            <th>Bank</th>
                                            <th>Account No</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($commissionList as $com)
                                            <tr>
                                                <td>{{ $com->created_at }}</td>
                                                <td>RM {{ number_format($com->amountRequest, 2) }}</td>
                                                <td>RM {{ number_format($com->before, 2) }}</td>
                                                <td>RM {{ number_format($com->after, 2) }}</td>
                                                <td>{{ $com->bank }}</td>
                                                <td>{{ $com->accountNo }}</td>
                                                <td>{{ $com->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
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

        document.getElementById("commission").className = "nav-link active";

    </script>
@endsection
