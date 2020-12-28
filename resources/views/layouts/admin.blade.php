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
    <link href="{{ asset('vendor/calendar/lib/main.css')}}" rel="stylesheet" />
    <script src="{{ asset('vendor/calendar/lib/main.js') }}"></script>
    
  
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
            <a href="/Dashboard" class="brand-logo">
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
                                <a class="nav-link" href="/profile-admin" role="button" data-toggle="dropdown">
                                    <img src="../imageUploaded/profile/{{ Auth::user()->image }}" width="20" alt="" />
                                    <div class="header-info">
                                        <span>Hey, <strong>{{ Auth::user()->name }}</strong></span>
                                        <small>{{ Auth::user()->role }}</small>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="/profile-admin" class="dropdown-item ai-icon">
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
                            <li><a href="/dashboard">Go to Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Manage Data</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> --}}
                            <i class="lni lni-list"></i>
                            <span class="nav-text">Orders</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="/view-order/pending">Pending Orders</a></li>
                            <li><a href="/view-order/completed">Completed Orders</a></li>
                            <li><a href="/update-order">Update Order (For Bulk Parcels)</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="lni lni-package"></i><span class="nav-text">Parcel</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="/parcel">Parcel Payment</a></li>
                            <li><a href="/bulk-parcel">Bulk Parcel</a></li>
                            <li><a href="/paid-parcel">Paid Parcel</a></li>
                        </ul>
                    </li>

                    <li><a class="ai-icon" href="/manageAgent" aria-expanded="false">
                            <i class="lni lni-users"></i>
                            <span class="nav-text">Agents</span>
                        </a>
                    </li>

                    <li><a class="ai-icon" href="/manageProduct" aria-expanded="false">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> --}}
                            <i class="lni lni-shopify"></i>
                            <span class="nav-text">Products</span>
                        </a>
                    </li>

                    <li><a class="ai-icon" href="/customers" aria-expanded="false">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> --}}
                            <i class="lni lni-customer"></i>
                            <span class="nav-text">Customers</span>
                        </a>
                    </li>

                    <li><a class="ai-icon" href="/blastMessage" aria-expanded="false">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> --}}
                            <i class="lni lni-mobile"></i> <span class="nav-text">Blast Message</span>
                        </a>
                    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> --}}
                            <i class="lni lni-help"></i>
                            <span class="nav-text">Help</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="/support">Support</a></li>
                            <li><a href="/customers">User Guidelines</a></li>
                        </ul>
                    </li>


                    {{-- <li><a class="ai-icon" href="/support" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <polygon fill="#000000" opacity="0.3" points="5 7 5 15 19 15 19 7" />
                                    <path
                                        d="M11,19 L11,16 C11,15.4477153 11.4477153,15 12,15 C12.5522847,15 13,15.4477153 13,16 L13,19 L14.5,19 C14.7761424,19 15,19.2238576 15,19.5 C15,19.7761424 14.7761424,20 14.5,20 L9.5,20 C9.22385763,20 9,19.7761424 9,19.5 C9,19.2238576 9.22385763,19 9.5,19 L11,19 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M5,7 L5,15 L19,15 L19,7 L5,7 Z M5.25,5 L18.75,5 C19.9926407,5 21,5.8954305 21,7 L21,15 C21,16.1045695 19.9926407,17 18.75,17 L5.25,17 C4.00735931,17 3,16.1045695 3,15 L3,7 C3,5.8954305 4.00735931,5 5.25,5 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <span class="nav-text">Support</span>
                        </a>
                    </li>
                    <li><a class="ai-icon" href="/guidelines" aria-expanded="false">
                            <span class="nav-text"><i class="nav-icon far fa-question-circle"></i>User Guidelines</span>
                        </a>
                    </li> --}}
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

    function number(e){
        e.target.value = e.target.value.replace(/[^\d]/g,'');
        return false;
    }

    function price(e){
        e.target.value = e.target.value.replace(/^[0-9\.]+$/,'');
        return false;
    }

    function alphabets(e){
        e.target.value = e.target.value.replace(/^[A-Za-z ]+$/,'');
        return false;
    }

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
