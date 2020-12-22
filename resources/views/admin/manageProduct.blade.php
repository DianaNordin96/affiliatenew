@extends('layouts.admin')
@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Agents</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Agents</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h3 class="card-title">View Employee</h3> -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                                <i class="lni lni-plus"></i> &nbsp Add Products
                            </button>
                            <br />
                            <br/>
                            <div class="table-responsive">
                                <table id="example5" class=" table table-striped table-responsive-sm">
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
                                                        src="../imageUploaded/products/{{ $product->product_image }}" />
                                                </td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>Actual Price: RM {{ number_format($product->product_price, 2) }}<br />
                                                    HQ Price: RM {{ number_format($product->price_hq, 2) }}<br />
                                                    Shogun Price: RM {{ number_format($product->price_shogun, 2) }}<br />
                                                    Damio Price: RM {{ number_format($product->price_damio, 2) }}<br />
                                                    Merchant Price: RM
                                                    {{ number_format($product->price_merchant, 2) }}<br />
                                                    Dropship Price: RM
                                                    {{ number_format($product->price_dropship, 2) }}<br />
                                                </td>
                                                <td><button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                        onclick="openModalEdit(
                                                                            '{{ $product->id }}',
                                                                            '{{ $product->product_name }}',
                                                                            '{{ $product->price_hq }}',
                                                                            '{{ $product->product_price }}',
                                                                            '{{ $product->product_description }}',
                                                                            '{{ $product->price_shogun }}',
                                                                            '{{ $product->price_damio }}',
                                                                            '{{ $product->price_merchant }}',
                                                                            '{{ $product->price_dropship }}',
                                                                            '{{ $product->product_link }}'
                                                                            )" data-target="#modalEdit"
                                                        class="btn btn-warning"><i class="lni lni-pencil-alt"></i></button> &nbsp;
                                                    <button type="button" title="View" data-toggle="modal" onclick="openModalView(
                                                                            '{{ $product->id }}',
                                                                            '{{ $product->product_name }}',
                                                                            '{{ $product->price_hq }}',
                                                                            '{{ $product->product_price }}',
                                                                            '{{ $product->product_description }}',
                                                                            '{{ $product->price_shogun }}',
                                                                            '{{ $product->price_damio }}',
                                                                            '{{ $product->price_merchant }}',
                                                                            '{{ $product->price_dropship }}',
                                                                            '{{ $product->product_link }}'
                                                                            )" data-target="#modalView"
                                                        class="btn btn-success"><i class="lni lni-eye"></i></button> &nbsp;

                                                    <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                        onclick="window.location.href='manageProduct/delete/{{ $product->id }}'"
                                                        class="btn btn-danger"><i class="lni lni-trash"></i></i></button>
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
        </div><!-- /.container-fluid -->
    </div>

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
                                <div class="form-group">
                                    <label>Product Description</label>
                                    <textarea class="form-control" name="productDesc" id="productDesc" rows="3"
                                        placeholder="Description"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Product Link</label>
                                    <input type="text" class="form-control" name="productLink" id="productLink"
                                        placeholder="Link" />
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
                                    <label> HQ Price </label>
                                    <input type="text" id="hqPrice" class="form-control" name="hqPrice"
                                        placeholder="HQ Price" />
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
                    <h4 class="modal-title">Product Details</h4>

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
                                    <input type="text" id="productNameEdit" class="form-control" name="productNameEdit"
                                        placeholder="Name" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Product Description</label>
                                    <textarea class="form-control" name="productDescEdit" id="productDescEdit" rows="3"
                                        placeholder="Description"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Product Link</label>
                                    <input type="text" class="form-control" name="productLinkEdit" id="productLinkEdit"
                                        placeholder="Link" />
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Actual Price </label>
                                    <input type="text" id="productPriceEdit" class="form-control" name="productPriceEdit"
                                        placeholder="Price" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> HQ Price </label>
                                    <input type="text" id="hqPriceEdit" class="form-control" name="hqPriceEdit"
                                        placeholder="HQ Price" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Shogun Price </label>
                                    <input type="text" id="shogunPriceEdit" class="form-control" name="shogunPriceEdit"
                                        placeholder="Shogun Price" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Damio Price </label>
                                    <input type="text" id="damioPriceEdit" class="form-control" name="damioPriceEdit"
                                        placeholder="Price" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Merchant Price </label>
                                    <input type="text" id="merchantPriceEdit" class="form-control" name="merchantPriceEdit"
                                        placeholder="Shogun Price" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label> Dropship Price </label>
                                    <input type="text" id="dropshipPriceEdit" class="form-control" name="dropshipPriceEdit"
                                        placeholder="Shogun Price" />
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
        <div class="modal-dialog modal-md">
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

        function openModalEdit(prodID, name, hq, price, desc, shogun, damio, merchant, dropship, link) {

            document.getElementById("productIDEdit").value = prodID;
            document.getElementById("productNameEdit").value = name;
            document.getElementById("hqPriceEdit").value = hq;
            document.getElementById("productPriceEdit").value = price;
            document.getElementById("productDescEdit").value = desc;
            document.getElementById("productLinkEdit").value = link;
            document.getElementById("shogunPriceEdit").value = shogun;
            document.getElementById("damioPriceEdit").value = damio;
            document.getElementById("merchantPriceEdit").value = merchant;
            document.getElementById("dropshipPriceEdit").value = dropship;

        }

        function openModalView(prodID, name, hq, price, desc, shogun, damio, merchant, dropship, link) {

            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                "<b>Actual Price: RM  </b>" + price + "<br/>" +
                "<b>Product Name:  </b>" + name + "<br/>" +
                "<b>Description: </b>" + desc + "<br/>" +
                "<b>Price HQ: </b> RM " + hq + "<br/>" +
                "<b>Price Shogun: </b> RM " + shogun + "<br/>" +
                "<b>Price Damio: </b> RM " + damio + "<br/>" +
                "<b>Price Merchant: </b> RM " + merchant + "<br/>" +
                "<b>Price Dropship: </b> RM " + dropship + "<br/>" +
                "<b>Product Link: </b><a href=" + link + ">" + link + "</a><br/>" +
                "</div>";
            "</div>";
        }

    </script>
@endsection
