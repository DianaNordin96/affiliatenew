@extends('layouts.masteradmin')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Products Category</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Products Category</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-warning">
                           
                            <div class="card-body">
                                <button type="button" class="btn btn-block btn-success" data-toggle="modal"
                                    data-target="#prodCat">
                                    <i class="lni lni-plus"></i> &nbsp Add Product Category
                                </button><br/>
                                <div class="table-responsive">
                                    <table id="example5" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Category ID</th>
                                            <th>Category Photo</th>
                                            <th>Category Name</th>
                                            <th>Desc</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allTypeProdCat as $value)
                                            <tr>
                                                <td style="text-align: center">{{ $value->id }}</td>
                                                <td><img height="150px" width="150px"
                                                    src="{{asset('imageUploaded/productCat/'.$value->image.'')}}" /></td>
                                                <td style="text-align: center">{{ $value->category }}</td>
                                                <td style="text-align: center">{{ $value->desc }}</td>
                                                <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                    onclick="openModalEditProd(
                                                        '{{ $value->id }}',
                                                        '{{ $value->category }}',
                                                        '{{ $value->desc }}'
                                                        )"
                                                    data-target="#editCategory" class="btn btn-success"><i
                                                        class="lni lni-pencil-alt"></i></button> &nbsp;
                                                    <button type="button" id="btnDelete" title="Delete" data-toggle="modal"
                                                    onclick="window.location.href='/master.delete.prodCat/{{ $value->id }}'"
                                                    class="btn btn-danger"><i class="lni lni-trash"></i></button>    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         {{-- modal add admin cat --}}
         <div class="modal fade" id="prodCat">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('master.create.prodCat') }}" method="post" enctype="multipart/form-data">
                            @csrf
                           
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Photo <span style="color:yellow">  *</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" id="image" name="image">
                                                <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label> Category Name <span style="color:yellow">  *</span></label>
                                        <input type="text" id="catName" class="form-control" name="catName"
                                            placeholder="Category Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Description <span style="color:yellow">  *</span></label>
                                        <textarea class="form-control" name="desc" id="desc" rows="3"
                                            placeholder="Description"></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>

        {{-- modal edit admin cat --}}
        <div class="modal fade" id="editCategory">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Admin Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('master.update.prodCat') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" id="idEdit" class="form-control" name="idEdit"
                            placeholder="Category Name" hidden/>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Photo <span style="color:yellow">  *only upload picture if need to change the picture</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" id="imageEdit" name="imageEdit">
                                                <!-- <label class="custom-file-label" for="exampleInputFile">Choose file</label> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label> Category Name </label>
                                        <input type="text" id="catNameEdit" class="form-control" name="catNameEdit"
                                            placeholder="Category Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="descEdit" id="descEdit" rows="3"
                                            placeholder="Description"></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
            
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')
    <script>
        function openModalEditProd(id, cat, desc) {
            document.getElementById("idEdit").value = id;
            document.getElementById("catNameEdit").value = cat;
            document.getElementById("descEdit").value = desc;
        }
    </script>
@endsection
