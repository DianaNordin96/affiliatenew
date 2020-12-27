
@inject('sales', 'App\Http\Controllers\Damio\SalesController')
@extends('layouts.damio')
@section('content')

    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <!-- Small boxes (Stat box) -->
                <div class="col-xl-3 col-lg-6 col-sm-6">
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

                <div class="col-xl-3 col-lg-6 col-sm-6">
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
                                    <p class="mb-1">Total Purchases</p>
                                    <h4 class="mb-0">{{ number_format($sales->getTotalPurchase(), 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6">
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
                                    <p class="mb-1">Total Profit</p>
                                    <h4 class="mb-0">
                                        {{ number_format($sales->getTotalSales() - $sales->getTotalPurchase(), 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6">
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
                                    <h4 class="mb-0">{{ $downline }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                
            
                <div class="col-xl-4 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Monthly Sales</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart_2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Monthly Purchases</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart_3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Monthly Profit</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart_4"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <!-- Left col -->
                <div class="col-xl-6 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-gradient-lightblue">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                DOWNLINE SALES THIS MONTH
                            </h3>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-lg-6 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>Merchant</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM {{ number_format($merchant, 2) }}</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="info-box bg-lightblue">
                                        <!-- <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span> -->
                                        <div class="info-box-content">
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>Dropship</h6>
                                            </span>
                                            <span style="text-align : center" class="info-box-text">
                                                <h6>RM {{ number_format($dropship, 2) }}</h6>
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="loading" style="display: none;
                            position: absolute;
                            top: 10px;
                            right: 10px;">loading...</div>

                            <div style="max-width: 1100px;
                            margin: 0 auto;" id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
  
      var calendar = new FullCalendar.Calendar(calendarEl, {
  
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,listYear'
        },
  
        displayEventTime: false, // don't show the time column in list view
  
        // THIS KEY WON'T WORK IN PRODUCTION!!!
        // To make your own Google API key, follow the directions here:
        // http://fullcalendar.io/docs/google_calendar/
        googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
  
        // US Holidays
        events: 'en.usa#holiday@group.v.calendar.google.com',
  
        eventClick: function(arg) {
          // opens events in a popup window
          window.open(arg.event.url, 'google-calendar-event', 'width=600,height=500');
  
          arg.jsEvent.preventDefault() // don't navigate in main tab
        },
  
        loading: function(bool) {
          document.getElementById('loading').style.display =
            bool ? 'block' : 'none';
        }
  
      });
  
      calendar.render();
    });
  
  </script>
<script>
    (function($) {
        "use strict"

        let draw = Chart.controllers.line.__super__.draw; //draw shadow

        
        //gradient line chart
        if (jQuery('#lineChart_2').length > 0) {

            const lineChart_2 = document.getElementById("lineChart_2").getContext('2d');
            
            const lineChart_2gradientStroke = lineChart_2.createLinearGradient(500, 0, 100, 0);
            lineChart_2gradientStroke.addColorStop(0, "rgba(58, 122, 254, 1)");
            lineChart_2gradientStroke.addColorStop(1, "rgba(58, 122, 254, 0.5)");

            Chart.controllers.line = Chart.controllers.line.extend({
                draw: function() {
                    draw.apply(this, arguments);
                    let nk = this.chart.chart.ctx;
                    let _stroke = nk.stroke;
                    nk.stroke = function() {
                        nk.save();
                        nk.shadowColor = 'rgba(0, 0, 128, .2)';
                        nk.shadowBlur = 10;
                        nk.shadowOffsetX = 0;
                        nk.shadowOffsetY = 10;
                        _stroke.apply(this, arguments)
                        nk.restore();
                    }
                }
            });

            lineChart_2.height = 100;

            new Chart(lineChart_2, {
                type: 'line',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Monthly Sales (RM)",
                        data: [
                        <?php 
                        
                        $salesGraph = $sales->getGraphSales();

                        foreach($salesGraph as $sale){
                            echo $sale.',';
                        }
                        ?>
                        ],
                        borderColor: lineChart_2gradientStroke,
                        borderWidth: "2",
                        backgroundColor: 'transparent',
                        pointBackgroundColor: 'rgba(58, 122, 254, 0.5)'
                    }]
                },
                options: {
                legend: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: {{max($salesGraph)}},
                            min: {{min($salesGraph)}},
                            stepSize: 100,
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }]
                }
            }
            });
        }
        
        //chart
        if (jQuery('#lineChart_3').length > 0) {

        const lineChart_3 = document.getElementById("lineChart_3").getContext('2d');
        const lineChart_3gradientStroke = lineChart_3.createLinearGradient(500, 0, 100, 0);
        lineChart_3gradientStroke.addColorStop(0, "rgba(58, 122, 254, 1)");
        lineChart_3gradientStroke.addColorStop(1, "rgba(58, 122, 254, 0.5)");

        Chart.controllers.line = Chart.controllers.line.extend({
            draw: function() {
                draw.apply(this, arguments);
                let nk = this.chart.chart.ctx;
                let _stroke = nk.stroke;
                nk.stroke = function() {
                    nk.save();
                    nk.shadowColor = 'rgba(0, 0, 128, .2)';
                    nk.shadowBlur = 10;
                    nk.shadowOffsetX = 0;
                    nk.shadowOffsetY = 10;
                    _stroke.apply(this, arguments)
                    nk.restore();
                }
            }
        });

        lineChart_3.height = 100;

        new Chart(lineChart_3, {
            type: 'line',
            data: {
                defaultFontFamily: 'Poppins',
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Purchases (RM)",
                    data: [
                    <?php 
                    
                    $purchasesGraph = $sales->getGraphPurchase();

                    foreach($purchasesGraph as $purchase){
                        echo $purchase.',';
                    }
                    ?>
                    ],
                    borderColor: lineChart_3gradientStroke,
                    borderWidth: "2",
                    backgroundColor: 'transparent',
                    pointBackgroundColor: 'rgba(58, 122, 254, 0.5)'
                }]
            },
            options: {
                legend: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: {{max($purchasesGraph)}},
                            min: {{min($purchasesGraph)}},
                            stepSize: 100,
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }]
                }
            }
        });
        }

        //chart
        if (jQuery('#lineChart_4').length > 0) {

        const lineChart_4 = document.getElementById("lineChart_4").getContext('2d');
        const lineChart_4gradientStroke = lineChart_4.createLinearGradient(500, 0, 100, 0);
        lineChart_4gradientStroke.addColorStop(0, "rgba(58, 122, 254, 1)");
        lineChart_4gradientStroke.addColorStop(1, "rgba(58, 122, 254, 0.5)");

        Chart.controllers.line = Chart.controllers.line.extend({
            draw: function() {
                draw.apply(this, arguments);
                let nk = this.chart.chart.ctx;
                let _stroke = nk.stroke;
                nk.stroke = function() {
                    nk.save();
                    nk.shadowColor = 'rgba(0, 0, 128, .2)';
                    nk.shadowBlur = 10;
                    nk.shadowOffsetX = 0;
                    nk.shadowOffsetY = 10;
                    _stroke.apply(this, arguments)
                    nk.restore();
                }
            }
        });

        lineChart_4.height = 100;

        new Chart(lineChart_4, {
            type: 'line',
            data: {
                defaultFontFamily: 'Poppins',
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Profit (RM)",
                    data: [
                    <?php 
                    
                    $profitGraph = $sales->getGraphProfit();

                    foreach($profitGraph as $profit){
                        echo $profit.',';
                    }
                    ?>
                    ],
                    borderColor: lineChart_4gradientStroke,
                    borderWidth: "2",
                    backgroundColor: 'transparent',
                    pointBackgroundColor: 'rgba(58, 122, 254, 0.5)'
                }]
            },
            options: {
                legend: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: {{max($profitGraph)}},
                            min: {{min($profitGraph)}},
                            stepSize: 100,
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            padding: 5
                        },
                        gridLines: {
                            color: 'rgba(192, 192, 192, 0.1)'
                        }
                    }]
                }
            }
        });
        }

    })(jQuery);
</script>
@endsection
