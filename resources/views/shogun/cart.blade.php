@extends('layouts.shogun')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cart</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('ShogunDashboard') }}">Dashboard</a>
                            <li class="breadcrumb-item active">Cart</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <form action="{{ url('checkout') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h3 class="card-title">View Employee</h3> -->
                                    <a href="{{ url('product-shogun') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                        Continue Shopping</a><br /><br />
                                    <div style="text-align:center">
                                        <h3>Shopping Cart</h3>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th width="50%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            $no = 1;
                                            ?>

                                            @if (session('cart'))
                                                @foreach (session('cart') as $id => $details)
                                                    <?php $total += $details['price'] * $details['quantity'];
                                                    ?>

                                                    <tr style="border-bottom: lightgrey  1px solid">
                                                        <td style="padding-left:10px;text-align: right">
                                                            #{{ $no }}
                                                        </td>
                                                        <td>
                                                            <br />
                                                            <img style="display: block;margin-left: auto;margin-right: auto;"
                                                                src="../imageUploaded/products/{{ $details['photo'] }}" width="80"
                                                                height="80" class="img-responsive" />
                                                            <br />
                                                            <div style="text-align: center">
                                                                {{ $details['name'] }}<br />
                                                                RM {{ $details['price'] }}/each
                                                            </div>
                                                            <br />
                                                        </td>
                                                        <td style="padding-left: 10%">
                                                            <div style="float: right">
                                                                Subtotal: RM
                                                                {{ $details['price'] * $details['quantity'] }}<br /><br />
                                                                <input type="number" value="{{ $details['quantity'] }}"
                                                                    style="width:60%" class="form-control quantity" /><br />
                                                                <a class="btn btn-info btn-sm update-cart"
                                                                    data-id="{{ $id }}"><i
                                                                        class="fas fa-sync-alt"></i></a> &nbsp;&nbsp;
                                                                <a class="btn btn-danger btn-sm remove-from-cart"
                                                                    data-id="{{ $id }}"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $no++; ?>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Customer Details</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Customer Name </label>
                                                        <input type="text" id="name" class="form-control" name="name"
                                                            placeholder="Name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Phone Number </label>
                                                        <input type="text" id="phone" class="form-control" name="phone"
                                                            placeholder="Phone Number" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label> Email </label>
                                                        <input type="text" id="email" class="form-control" name="email"
                                                            placeholder="Email" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #1</label>
                                                        <input type="text" id="address1" class="form-control"
                                                            name="address1" placeholder="" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Address #2 (Optional) </label>
                                                        <input type="text" id="address2" class="form-control"
                                                            name="address2" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Address #3 (Optional) </label>
                                                        <input type="text" id="address3" class="form-control"
                                                            name="address3" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" id="city" class="form-control" name="city"
                                                            placeholder="" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <select class="form-control select2bs4"  name="state">
                                                            <option value="jhr">Johor</option>
                                                            <option value="kdh">Kedah</option>
                                                            <option value="ktn">Kelantan</option>
                                                            <option value="mlk">Melaka</option>
                                                            <option value="nsn">Negeri Sembilan </option>
                                                            <option value="phg">Pahang</option>
                                                            <option value="prk">Perak</option>
                                                            <option value="pls">Perlis</option>
                                                            <option value="png">Pulau Pinang</option>
                                                            <option value="sgr">Selangor</option>
                                                            <option value="trg">Terengganu</option>
                                                            <option value="kul">Kuala Lumpur</option>
                                                            <option value="pjy">Putra Jaya</option>
                                                            <option value="srw">Sarawak</option>
                                                            <option value="sbh">Sabah</option>
                                                            <option value="lbn">Labuan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Postcode</label>
                                                        <input type="text" id="postcode" class="form-control" name="postcode"
                                                            placeholder="" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div style="float:center" class="col-lg-12 col-md-12 col-xs-12">
                                            <strong>
                                                <h4>Total RM {{ number_format($total, 2) }} &nbsp; &nbsp;
                                                    @if (session()->get('cart') != null)
                                                        <button type="submit" id="checkout" class="btn btn-info">
                                                            Checkout
                                                            <i class="fa fa-angle-right"></i></button>
                                                    @endif
                                                </h4>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
    
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
    
            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()
    
            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )
    
            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })
    
            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()
    
            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()
    
            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });
    
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
    
        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        });
    
        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false;
    
        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);
    
        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        });
    
        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            };
        });
    
        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });
    
        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });
    
        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";
        });
    
        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true);
        };
        // DropzoneJS Demo Code End
    </script>
    <script type="text/javascript">
        $(".update-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('update-cartShogun') }}',
                method: "patch",
                data: {
                    _token:'{{csrf_token()}}',
                    id: ele.attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cartShogun')}}',
                    method: "DELETE",
                    data: {
                        _token: '{{csrf_token()}}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
@endsection
