
@inject('agent', 'App\Http\Controllers\MasterAdmin\ManageAgentController')
@extends('layouts.masteradmin')
@section('content')

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-2 p-md-0">
                    <button onclick="goBack()" type="button" class="btn btn-success"><i class="fa fa-angle-left"></i>
                        Go Back</button>
                    </div>
                <div class="col-sm-4 p-md-0">
                    <div class="welcome-text">
                        <h4>Agents</h4>
                        <span>Profile</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->


                <div class="row">
                    <div class="col-lg-6">
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

                    <div class="col-lg-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Downline Agents</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <?php $getDownline = $agent->getDownline($users[0]->id);?>

                            @foreach($getDownline as $key => $dl)
                            <strong><i class="lni lni-user"></i> {{$dl[0]->name}} </strong>
                                <p class="text-muted">
                                    Position : {{$dl[0]->role}}
                                </p>
                                <hr> 
                            @endforeach
                            
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
