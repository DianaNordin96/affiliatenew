@inject('sales', 'App\Http\Controllers\MasterAdmin\SalesController')
@extends('layouts.masteradmin')
@section('content')


<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Small boxes (Stat box) -->
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body  p-4">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <path d="M12,1L12,23" style="stroke-dasharray: 22, 42; stroke-dashoffset: 0;">
                                    </path>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                                        style="stroke-dasharray: 43, 63; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Sales</p>
                                <h4 class="mb-0">{{ number_format($sales->getTotalSales(), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body  p-4">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-revenue2" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <path d="M12,1L12,23" style="stroke-dasharray: 22, 42; stroke-dashoffset: 0;">
                                    </path>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                                        style="stroke-dasharray: 43, 63; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Gross Profit</p>
                                <h4 class="mb-0">{{ number_format($sales->getTotalPurchase(), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body  p-4">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <svg id="icon-revenue3" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <path d="M12,1L12,23" style="stroke-dasharray: 22, 42; stroke-dashoffset: 0;">
                                    </path>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"
                                        style="stroke-dasharray: 43, 63; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Sales</p>
                                <h4 class="mb-0">
                                    {{ number_format($sales->getTotalSales() - $sales->getTotalPurchase(), 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="mr-3">
                                <!-- <i class="ti-user"></i> -->
                                <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                        style="stroke-dasharray: 25, 45; stroke-dashoffset: 0;"></path>
                                    <path d="M8,7A4,4 0,1,1 16,7A4,4 0,1,1 8,7"
                                        style="stroke-dasharray: 26, 46; stroke-dashoffset: 0;"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Agents</p>
                                <h4 class="mb-0">{{ $totalAgent }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            

            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart_2"></canvas>
                    </div>
                </div>
            </div>
            
            
            <!-- Left col -->
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header bg-gradient-lightblue">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            DOWNLINE SALES THIS MONTH
                        </h3>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 ">
                                <div class="info-box bg-lightblue">
                                    <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                    <div class="info-box-content">
                                        <span style="text-align : center" class="info-box-text">
                                            <h6>Shogun</h6>
                                        </span>
                                        <span style="text-align : center" class="info-box-text">
                                            <h6>RM {{ number_format($shogunSales, 2) }}</h6>
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
                                            <h6>Damio</h6>
                                        </span>
                                        <span style="text-align : center" class="info-box-text">
                                            <h6>RM {{ number_format($damioSales, 2) }}</h6>
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
                                            <h6>RM {{ number_format($merchantSales, 2) }}</h6>
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
                                            <h6>RM {{ number_format($dropshipSales, 2) }}</h6>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.card-body -->


            </div>
        </div>
    </div>
</div>

@endsection