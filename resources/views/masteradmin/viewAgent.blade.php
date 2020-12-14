
@inject('agent', 'App\Http\Controllers\MasterAdmin\ManageAgentController')
@extends('layouts.masteradmin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$users[0]->name}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('MasterDashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Agents</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-4">
                       <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../imageUploaded/profile/{{ $users[0]->image }}"
                                    alt="User profile picture">
                            </div>
            
                            <h3 class="profile-username text-center">{{ $users[0]->name }}</h3>
            
                            <p class="text-muted text-center">{{ $users[0]->role }}</p>
            
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>IC</b> <a class="float-right">{{$users[0]->icnumber}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Date Of Birth</b> <a class="float-right">{{$users[0]->dob}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Commission</b> <a class="float-right">{{number_format($users[0]->commissionPoint,2)}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$users[0]->email}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{$users[0]->phone}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">{{$users[0]->address}}</a>
                                </li>
                                <li class="list-group-item">
                                <b>Total Downline</b> <a class="float-right">{{$agent->countDownline($users[0]->id)}}</a>
                                </li>
                            </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-lg-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Downline Agents</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <?php $getDownline = $agent->getDownline($users[0]->id);?>

                            @foreach($getDownline as $key => $dl)
                            <strong><i class="fas fa-user mr-1"></i> {{$dl[0]->name}} </strong>
                                <p class="text-muted">
                                    Position : {{$dl[0]->role}}
                                </p>
                                <hr> 
                            @endforeach
                            
                            </div>
                      
                    </div>
                </div>
            </div><!-- /.container-fluid -->

            <!-- /.modal -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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

        document.getElementById("customerDetails").className = "nav-link active";

    </script>
@endsection
