@extends('layouts.dropship')
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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


                            <h3>$35,210.43</h3>
                            <p>Total Sales <span class="text-success"> &nbsp; &nbsp; <i class="fas fa-caret-up"></i> 17%</span></p>

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
                            <h3>44</h3>

                            <p>Total Customer</p>
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
                <!-- Left col -->
                {{-- <section class="col-lg-6 connectedSortable">

                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                CUSTOMER SALES
                            </h3>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>TODAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>YESTERDAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->

                </section> --}}
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                DOWNLINE (BULK ORDER) SALES
                            </h3>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>TODAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>YESTERDAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                TOTAL SALES (CUSTOMER + DOWNLINE)
                            </h3>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>TODAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>THIS MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>YESTERDAY</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST WEEK</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="info-box bg-navy">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>LAST MONTH</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM 0.00</h6>
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