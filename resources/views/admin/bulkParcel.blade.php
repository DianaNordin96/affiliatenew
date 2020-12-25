@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Bulk Parcels</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Bulk Parcel</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

            <div class="row">
                <div style="margin: auto;" class="col-lg-8">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Create Bulk Orders Consignment</h3>

                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <h4 style="text-align: center">Username: </h4>
                            <h4 style="text-align: center">Password: </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="https://easyparcel.com/application/source/Malaysia/Template/EasyParcel_Bulk_Template[MY_9.2].xls">
                                        <button class="btn btn-block btn-warning">Download Bulk Template</button>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a target="_blank" href="https://easyparcel.com/my/en/bulk/"
                                    class="btn btn-block btn-danger">Import Bulk Orders Here</a>
                                </div>
                            </div>
<br/>
                            <div class="row">
                                <div class="col-md-12">
                                 <h3>Steps for Bulk Parcels</h3>
                                 <p><b>1. </b> Download the official template by clicking on 'Download Bulk Template'.</p>
                                 <p><b>2. </b> Export pending orders from <a target="_blank" href="view-order/pending">Pending Orders</a> by clicking on 'Export Order List to Excel.</p>
                                 <p><b>3. </b> Open the Order List that were downloaded in Step 2.</p>
                                 <p><b>4. </b> Copy all the row details and paste in it the downloaded template from Step 1.</p>
                                 <p><b>5. </b> Fill in all the details and make sure do not leave any empty fields especially on (*) fields.</p>
                                 <p><b>6. </b> After complete with all details, upload the Excel file (Excel file with completed details) <a target="_blank" href="https://easyparcel.com/my/en/bulk/">here</a>. </p>
                                 <p><b>7. </b> Final step, after complete all of these steps and parcels has been paid, make sure to update the all the orders' parcel details <a href="/update-order">here</a>.</p>
                                </div>
                            </div>
                            
                            <form action="{{ url('bulk-parcel-import') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="row"> --}}
                                {{-- <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="excelFile" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                {{-- <div class="col-12">
                                        <div class="form-group"> --}}
                                {{-- <label>Multiple</label> --}}
                                {{-- <select class="duallistbox" name="orders[]" multiple="multiple">
                                            <option>Alabama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                            <option>Delaware</option>
                                            <option>Tennessee</option>
                                            <option>Texas</option>
                                            <option>Washington</option>
                                            </select> --}}
                                {{-- </div> --}}
                                <!-- /.form-group -->
                                {{-- </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <button type="submit" class="btn btn-block bg-danger">Store Data into
                                        Orders</button>
                                </div> --}}
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(function () {
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

    document.getElementById("bulk-parcel").className = "nav-link active";
    document.getElementById("menuParcel").className = "nav-link active";
    document.getElementById("menuParcels").className = "nav-item menu-open has-treeview";
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

</script>
@endsection
