@inject('customer', 'App\Http\Controllers\Merchant\CustomerController')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <!-- Datatable -->
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    
  
</head>


<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/MerchantDashboard" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/logo-white.png') }}" alt="">
                <img class="logo-compact" src="{{ asset('images/logo-text.png') }}" alt="">
                <img class="brand-title" src="{{ asset('images/logo-text.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Chat box start
        ***********************************-->
        <div class="chatbox">
            <div class="chatbox-close"></div>
            <div class="custom-tab-1">

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="chat" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                            <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                                <div class="card">
                                    <div class="card-body">
                                        <div style="text-align:center">
                                            <span style="font-size: 20px;" class="text-muted">Your cart</span>&nbsp;&nbsp;
                                            <span style="font-size: 20px;" class="badge badge-primary badge-pill">
                                                @if (session('cartPayment') != null)
                                                {{ count(session('cartPayment')) }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <br/><br/>
                                            <a class="btn btn-warning" style="color:black; width:100%" href="/merchant-cart">Click here to edit your cart</a>
                                        </div>
    
                                        <?php
                                            $total = 0;
                                            $no = 1;
                                            
                                            $cartPayment = session('cartPayment');
                                            // dd($cartPayment);
                                            ?>
                                        <br>
                                        <ul class="list-group mb-3">
                                                @if (session('cartPayment'))
                                                    @foreach ( $cartPayment as $key=>$value)
                                                    <?php $getCustomer = $customer->getCustomer($key); $totalOne = 0;?>
                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                            <div>
                                                                <h6 class="my-0">{{$getCustomer[0]->name}}</h6><br>
                                                                <small class="text-muted">
                                                                    
                                                                    @foreach($cartPayment[$key][0] as $id => $details)
                                                                    <?php 
                                                                        $total += $details['price'] * $details['quantity']; 
                                                                        $totalOne += $details['price'] * $details['quantity']; 
                                                                    ?>
                                                        
                                                                <div style="text-align: left">
                                                                    {{ $details['name'] }}<br />
                                                                    Qty : {{$details['quantity']}}<br/>
                                                                </div>
                                                        @endforeach
                                                                </small>
                                                            </div>
                                                            <span class="text-muted">RM {{number_format($totalOne,2)}}</span>
                                                        </li>
                                                    @endforeach
                                                @endif
                                        </ul>
                                        <form action="{{ url('checkout-merchant') }}" method="POST">
                                            @csrf
                                            <div style="position: fixed; bottom: 20px;" class="row">
                                                <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                                    <br>
                                                    <strong>
                                                        <h4>Total RM {{ number_format($total, 2) }}
                                                            <br/><br/>
                                                            @if (session()->get('cartPayment') != null)
                                                                <button style="display: block;
                                                                width: 100%;
                                                                border: none;
                                                                background-color: #4CAF50;
                                                                padding: 14px 28px;
                                                                font-size: 16px;
                                                                cursor: pointer;
                                                                text-align: center;" type="submit" id="checkout" class="btn btn-block btn-info">
                                                                    Checkout
                                                                    <i class="fa fa-angle-right"></i></button>
                                                            @endif
                                                        </h4>
                                                    </strong>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Chat box End
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">

                        </div>

                        <ul class="navbar-nav header-right">
                            

                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="/profile-merchant" role="button" data-toggle="dropdown">
                                    <img src="../imageUploaded/profile/{{ Auth::user()->image }}" width="20" alt="" />
                                    {{-- <img src="{{ asset('imageUploaded/avatar.png') }}" width="20" alt="" />  --}}
                                    <div class="header-info">
                                        <span>Hey, <strong>{{ Auth::user()->name }}</strong></span>
                                        <small>{{ Auth::user()->role }}</small>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="/profile-merchant" class="dropdown-item ai-icon">
                                        <svg id="icon-userh" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ml-2">Profile </span>
                                    </a>

                                    <a href="/logout" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ml-2">Logout </span>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item right-sidebar">
                                <a class="nav-link ai-icon" href="#">
                                    <i class="lni lni-cart"></i>&nbsp;<span class="badge badge-danger navbar-badge">
                                        @if (session('cartPayment') != null)
                                            {{ count(session('cartPayment')) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                    <path
                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="/MerchantDashboard">Go to Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Manage Data</li>

                    <li><a title="Downline Agent" class="ai-icon" href="/downline-merchant" aria-expanded="false">
                            <i class="lni lni-users"></i>
                            <span class="nav-text">Downline Agent</span>
                        </a>
                    </li>

                    <li><a title="Customers" class="ai-icon" href="/customers-merchant" aria-expanded="false">
                            <i class="lni lni-customer"></i>
                            <span class="nav-text">Customers</span>
                        </a>
                    </li>

                    <li><a title="Buy Product" class="ai-icon" href="/product-merchant" aria-expanded="false">
                            <i class="lni lni-shopify"></i>
                            <span class="nav-text">Buy Product</span>
                        </a>
                    </li>

                    <li><a title="Purchase History" class="ai-icon" href="/purchase-history-merchant" aria-expanded="false">
                            <i class="lni lni-list"></i> <span class="nav-text">Purchase History</span>
                        </a>
                    </li>

                    <li><a title="Commission" class="ai-icon" href="/commission-merchant" aria-expanded="false">
                        <i class="lni lni-wallet"></i> <span class="nav-text">Commission</span>
                    </a>
                </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="lni lni-help"></i>
                            <span class="nav-text">Help</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="/support-merchant">Support</a></li>
                            <li><a href="/guideline-merchant">User Guidelines</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        @yield('content')

        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignlab.com/" target="_blank">DexignLab</a>
                    2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->


    <!-- Required vendors -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <!-- Apex Chart -->
    <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>

    <!-- Vectormap -->
    <!-- Chart piety plugin files -->
    <script src="{{ asset('vendor/peity/jquery.peity.min.js') }}"></script>

    <!-- Chartist -->
    <script src="{{ asset('vendor/chartist/js/chartist.min.js') }}"></script>
    {{-- <script src="{{ asset('js/plugins-init/chartjs-init.js') }}"></script> --}}

    
    <!-- Dashboard 1 -->
    <script src="{{ asset('js/dashboard/dashboard-2.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>

    <!-- Svganimation scripts -->
    <script src="{{ asset('vendor/svganimation/vivus.min.js') }}"></script>
    <script src="{{ asset('vendor/svganimation/svg.animation.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <!-- All init script -->
    {{-- <script src="{{ asset('js/plugins-init/toastr-init.js') }}"></script> --}}
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/select2-init.js') }}"></script>


 <script>
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        };

    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif

    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        // Swal.fire(
        // 'The Internet?',
        // 'That thing is still around?',
        // 'success'
        // )
    @endif

    @if(Session::has('failed'))
        toastr.error("{{ Session::get('failed') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    function isPriceKey(e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[0-9\.]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                return false;
            }

            return isValid;
        }


        function isAlphabetsKey(e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[A-Za-z ]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                return false;
            }

            return isValid;
        }

        function isNumberKey(e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets.
            var regex = /^[0-9]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                return false;
            }

            return isValid;
        }
        
        (function($) {
            "use strict"

            var direction = getUrlParams('dir');
            if (direction != 'rtl') {
                direction = 'ltr';
            }

            new dezSettings({
                typography: "roboto",
                version: "dark",
                layout: "vertical",
                headerBg: "color_2",
                navheaderBg: "color_1",
                sidebarBg: "color_2",
                sidebarStyle: "full",
                sidebarPosition: "fixed",
                headerPosition: "fixed",
                containerLayout: "wide",
                direction: direction
            });

        })(jQuery);



    </script>

    <script>
    function goBack() {
      window.history.back();
    }
    </script>

    {{-- @include('sweetalert::alert') --}}

    @yield('script')
</body>

</html>
