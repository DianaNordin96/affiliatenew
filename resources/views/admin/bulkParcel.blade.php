@extends('layouts.admin')
@section('headScript')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bulk Parcel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                        <li class="breadcrumb-item active">Bulk Parcel</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Update Bulk Orders Records</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <h4 style="text-align: center">Username: </h4>
                            <h4 style="text-align: center">Password: </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <a
                                        href="https://easyparcel.com/application/source/Malaysia/Template/EasyParcel_Bulk_Template[MY_9.2].xls">
                                        <button class="btn btn-block bg-warning">Download Bulk Template</button>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a target="_blank" href="https://easyparcel.com/my/en/bulk/"
                                    class="btn btn-block bg-danger">Import Bulk Orders Here</a>
                                </div>
                            </div>
<br/>
                            <div class="row">
                                <div class="col-md-6">
                                 <h3>Steps for Bulk Parcels</h3>
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.card -->


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
