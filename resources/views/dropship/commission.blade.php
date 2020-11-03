@extends('layouts.dropship')
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
                        <h1>Commission</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('DropshipDashboard') }}">Dashboard</a>
                            <li class="breadcrumb-item active">Commission</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Total Commission</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
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

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('commission-dropship-withdrawal') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Amount To Withdraw</label>
                                                <input type="number" id="amount" class="form-control" name="amount"
                                                    placeholder="Amount to withdraw" required />
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- text input -->

                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Bank Name </label>
                                                <input type="text" id="bank" class="form-control" name="bank"
                                                    placeholder="Bank Name" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> Account No. </label>
                                                <input type="text" id="accountNo" class="form-control" name="accountNo"
                                                    placeholder="Account Number" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-block bg-danger">Request for
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

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
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
                            <!-- /.card-body -->
                        </div>
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
