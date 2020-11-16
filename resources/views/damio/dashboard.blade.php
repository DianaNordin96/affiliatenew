@extends('layouts.damio')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ url('DamioDashboard') }}">Dashboard</a>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h4>RM {{ number_format($totalSale,2) }}</h4>
                            <p>Total Sales <span class="text-success"> &nbsp; &nbsp;</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h4>{{ $downline }}</h4>

                            <p>Total Agent Downline</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">

                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            <h3 class="card-title">
                                <i class="fas fa-dollar-sign mr-1"></i>
                                SALES THIS MONTH
                            </h3>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>Own Sale</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM {{ number_format($own,2) }}</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-lg-3 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>Merchant</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM RM {{ number_format($merchant,2) }}</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-lg-3 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>Dropship</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM {{ number_format($dropship,2) }}</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </section>

            </div>
            <!-- /.card -->
        </div>
    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

    </section>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
