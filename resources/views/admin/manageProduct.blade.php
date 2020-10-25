@extends('layouts.admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manage Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                <button type="button" class="btn btn-block bg-gradient-lightblue" data-toggle="modal"
                                    data-target="#modal-lg">
                                    <i class="fas fa-plus"></i> &nbsp Add Products
                                </button>
                                <br />
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th width="10%">Image</th>
                                            <th>Product Name</th>
                                            <th>Price (RM)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td><img height="150px" width="150px"
                                                        src="/imageUploaded/{{ $product->product_image }}" /></td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>Actual Price: RM {{ number_format($product->product_price,2) }}<br/>
                                                    Shogun Price: RM {{ number_format($product->price_shogun,2) }}<br/>
                                                    Damio Price: RM {{ number_format($product->price_damio,2) }}<br/>
                                                    Merchant Price: RM {{ number_format($product->price_merchant,2) }}<br/>
                                                    Dropship Price: RM {{ number_format($product->price_dropship,2) }}<br/>
                                                </td>
                                                <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                        onclick="openModalEdit(
                                                                    '{{ $product->id }}',
                                                                    '{{ $product->product_name }}',
                                                                    '{{ $product->product_price }}',
                                                                    '{{ $product->product_description }}',
                                                                    '{{ $product->price_shogun }}',
                                                                    '{{ $product->price_damio }}',
                                                                    '{{ $product->price_merchant }}',
                                                                    '{{ $product->price_dropship }}'
                                                                    )" data-target="#modalEdit" class="btn btn-warning"><i
                                                            class="fas fa-edit"></i></button> &nbsp;
                                                    <button type="button" title="View" data-toggle="modal" onclick="openModalView(
                                                                    '{{ $product->id}}',
                                                                    '{{ $product->product_name }}',
                                                                    '{{ $product->product_price }}',
                                                                    '{{ $product->product_description }}',
                                                                    '{{ $product->price_shogun }}',
                                                                    '{{ $product->price_damio }}',
                                                                    '{{ $product->price_merchant }}',
                                                                    '{{ $product->price_dropship }}'
                                                                    )" data-target="#modalView" class="btn btn-success"><i
                                                            class="far fa-eye"></i></button> &nbsp;

                                                            <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                onclick="window.location.href='manageProduct/delete/{{$product->id}}'" class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.container-fluid -->

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('manageProduct.create') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Name </label>
                                            <input type="text" id="productName" class="form-control" name="productName"
                                                placeholder="Name" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo</label>
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
                                    <div class="col-sm-6">
                                        <!-- text input -->

                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Product Description</label>
                                            <textarea class="form-control" name="productDesc" id="productDesc" rows="3"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Actual Price </label>
                                            <input type="text" id="productPrice" class="form-control" name="productPrice"
                                                placeholder="Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Price </label>
                                            <input type="text" id="shogunPrice" class="form-control" name="shogunPrice"
                                                placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Price </label>
                                            <input type="text" id="damioPrice" class="form-control" name="damioPrice"
                                                placeholder="Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Price </label>
                                            <input type="text" id="merchantPrice" class="form-control" name="merchantPrice"
                                                placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Price </label>
                                            <input type="text" id="dropshipPrice" class="form-control" name="dropshipPrice"
                                                placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Products</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

            <div class="modal fade" id="modalEdit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Employee Details</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('manageProduct.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="productIDEdit" id="productIDEdit" hidden />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Name </label>
                                            <input type="text" id="productNameEdit" class="form-control"
                                                name="productNameEdit" placeholder="Name" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->

                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Product Description</label>
                                            <textarea class="form-control" name="productDescEdit" id="productDescEdit"
                                                rows="3" placeholder="Description"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Actual Price </label>
                                            <input type="text" id="productPriceEdit" class="form-control"
                                                name="productPriceEdit" placeholder="Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Price </label>
                                            <input type="text" id="shogunPriceEdit" class="form-control"
                                                name="shogunPriceEdit" placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Price </label>
                                            <input type="text" id="damioPriceEdit" class="form-control"
                                                name="damioPriceEdit" placeholder="Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Price </label>
                                            <input type="text" id="merchantPriceEdit" class="form-control"
                                                name="merchantPriceEdit" placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Price </label>
                                            <input type="text" id="dropshipPriceEdit" class="form-control"
                                                name="dropshipPriceEdit" placeholder="Shogun Price" />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

            <div class="modal fade" id="modalView">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="viewEmpName"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-body-view">

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')
    <script>
        $(function() {
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

        document.getElementById("manageProduct").className = "nav-link active";

        function openModalEdit(prodID,name, price, desc , shogun, damio, merchant, dropship) {

            document.getElementById("productIDEdit").value = prodID;
            document.getElementById("productNameEdit").value = name;
            document.getElementById("productPriceEdit").value = price;
            document.getElementById("productDescEdit").value = desc;
            document.getElementById("shogunPriceEdit").value = shogun;
            document.getElementById("damioPriceEdit").value = damio;
            document.getElementById("merchantPriceEdit").value = merchant;
            document.getElementById("dropshipPriceEdit").value = dropship;

        }

        function openModalView(prodID,name, price, desc  , shogun, damio, merchant, dropship) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<b>Actual Price: RM  </b>" + price + "<br/>" +
                "<b>Product Name:  </b>" + name + "<br/>" +
                "<b>Description: </b>" + desc + "<br/>" +
                "<b>Price Shogun: </b> RM " + shogun + "<br/>" +
                "<b>Price Damio: </b> RM " + damio + "<br/>" +
                "<b>Price Merchant: </b> RM " + merchant + "<br/>" +
                "<b>Price Dropship: </b> RM " + dropship + "<br/>" +
                "</div>";
            "</div>";
        }

    </script>
@endsection
