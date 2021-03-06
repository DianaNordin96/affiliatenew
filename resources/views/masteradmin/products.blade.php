@inject('category', 'App\Http\Controllers\MasterAdmin\ManageAdminController')
@inject('product_cat', 'App\Http\Controllers\MasterAdmin\ProductController')
@extends('layouts.masteradmin')
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Products</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Products</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h3 class="card-title">View Employee</h3> -->
                                <button type="button" class="btn btn-block btn-success" data-toggle="modal"
                                    data-target="#modal-lg">
                                    <i class="lni lni-plus"></i> &nbsp Add Products
                                </button>
                                <br />
                                <div class="table-responsive">
                                    <table id="example5" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th width="10%">Image</th>
                                            <th>Product Name</th>
                                            <th>Links</th></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td><img height="150px" width="150px"
                                                        src="../imageUploaded/products/{{ $product->product_image }}" /></td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>
                                                    {{-- Actual Price: RM {{ number_format($product->product_price, 2) }}<br />
                                                    HQ Cost: RM {{ number_format($product->price_hq, 2) }}<br />
                                                    Shogun Profit: RM {{ number_format($product->price_shogun, 2) }}<br />
                                                    Damio Profit: RM {{ number_format($product->price_damio, 2) }}<br />
                                                    Merchant Profit: RM
                                                    {{ number_format($product->price_merchant, 2) }}<br />
                                                    Dropship Profit: RM
                                                    {{ number_format($product->price_dropship, 2) }}<br /> --}}

                                                    <?php $links = explode(',',$product->product_link);  ?>

                                                    @foreach($links as $link)
                                                    <a style="color:lightseagreen;text-decoration-line: underline;" href="{{$link}}">{{$link}}</a><br/>
                                                    @endforeach
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
                                                                    '{{ $product->product_link }}',
                                                                    '{{ $product->belongToAdmin }}',
                                                                    '{{ $product->product_cat }}',
                                                                    '{{ $product->shogun_cost }}',
                                                                    '{{ $product->damio_cost }}',
                                                                    '{{ $product->merchant_cost }}',
                                                                    '{{ $product->dropship_cost }}'
                                                                    )" data-target="#modalEdit" class="btn btn-warning"><i
                                                            class="lni lni-pencil-alt"></i></button> &nbsp;
                                                    <button type="button" title="View" data-toggle="modal" onclick="openModalView(
                                                                    '{{ $product->id}}',
                                                                    '{{ $product->product_name }}',
                                                                    '{{ $product->price_hq }}',
                                                                    '{{ $product->product_price }}',
                                                                    '{{ $product->product_description }}',
                                                                    '{{ $product->price_shogun }}',
                                                                    '{{ $product->price_damio }}',
                                                                    '{{ $product->price_merchant }}',
                                                                    '{{ $product->price_dropship }}',
                                                                    '{{ $product->product_link }}',
                                                                    '{{ $product->belongToAdmin }}',
                                                                    '{{ $product->product_cat }}',
                                                                    '{{ $product->shogun_cost }}',
                                                                    '{{ $product->damio_cost }}',
                                                                    '{{ $product->merchant_cost }}',
                                                                    '{{ $product->dropship_cost }}'
                                                                    )" data-target="#modalView" class="btn btn-success"><i
                                                            class="lni lni-eye"></i></button> &nbsp;

                                                            <button type="button" id="buttonEdit" title="Edit" data-toggle="modal"
                                                onclick="window.location.href='/product-delete-master/{{$product->id}}'" class="btn btn-danger"><i class="lni lni-trash"></i></i></button>
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
                            <form action="{{ url('product-create-master') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Name <span style="color:yellow">  *</span></label>
                                            <input type="text" id="productName" class="form-control" name="productName"
                                                 />
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
                                            <label>Product Description <span style="color:yellow">  *</span></label>
                                            <textarea class="form-control" name="productDesc" id="productDesc" rows="3"
                                                ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Product Link (use(,) if link more than 1) </label>
                                            <textarea class="form-control" name="productLink" id="productLink" rows="3"
                                                ></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Actual Price <span style="color:yellow">  *</span></label>
                                            <input type="text" id="productPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="productPrice"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="hqPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="hqPrice"
                                                 />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="shogunCost" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="shogunCost"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="shogunPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="shogunPrice"
                                                />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="damioCost" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="damioCost"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="damioPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="damioPrice"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="merchantCost" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="merchantCost"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="merchantPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                             class="form-control" name="merchantPrice"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="dropshipCost" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="dropshipCost"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="dropshipPrice" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                             class="form-control" name="dropshipPrice"
                                                 />
                                        </div>
                                    </div>

                                </div>
                                    <?php 
                                    $allAdminType = $category->getAllAdminType(); 
                                    $allProdCategory = $product_cat->getAllProdCat();
                                    ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Admin Category <span style="color:yellow">  *</span></label>
                                            <select class="form-control" name="category">
                                                @foreach($allAdminType as $value)
                                                    <option value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Category <span style="color:yellow">  *</span></label>
                                            <select class="form-control" name="prod_category">
                                                @foreach($allProdCategory as $value)
                                                    <option value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
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
                            <form action="{{  url('product-update-master')  }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="productIDEdit" id="productIDEdit" hidden />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Name <span style="color:yellow">  *</span></label>
                                            <input type="text" id="productNameEdit" class="form-control"
                                                name="productNameEdit"  />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo</label>
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
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Product Description <span style="color:yellow">  *</span></label>
                                            <textarea class="form-control" name="productDescEdit" id="productDescEdit"
                                                rows="3" ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Product Link (use(,) if link more than 1) </label>
                                            <textarea class="form-control" name="productLinkEdit" id="productLinkEdit" rows="3"
                                                ></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Actual Price <span style="color:yellow">  *</span></label>
                                            <input type="text" id="productPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="productPriceEdit"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="hqPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="hqPriceEdit"
                                                 />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="shogunCostEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="shogunCostEdit"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Shogun Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="shogunPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="shogunPriceEdit"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="damioCostEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="damioCostEdit"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Damio Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="damioPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="damioPriceEdit"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="merchantCostEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="merchantCostEdit"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Merchant Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="merchantPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="merchantPriceEdit"
                                                 />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Cost <span style="color:yellow">  *</span></label>
                                            <input type="text" id="dropshipCostEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)"
                                            class="form-control" name="dropshipCostEdit"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Dropship Profit <span style="color:yellow">  *</span></label>
                                            <input type="text" id="dropshipPriceEdit" onkeyup="price(event);" onkeypress="return isPriceKey(event)" class="form-control" name="dropshipPriceEdit"
                                                 />
                                        </div>
                                    </div>

                                    <?php $allAdminType = $category->getAllAdminType(); 
                                    $allProdCategory = $product_cat->getAllProdCat();
                                    ?>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Admin Category <span style="color:yellow">  *</span></label>
                                            <select class="form-control" id="categoryEdit" name="categoryEdit" readonly>
                                                @foreach($allAdminType as $value)
                                                    <option value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Product Category <span style="color:yellow">  *</span></label>
                                            <select class="form-control"  id="prodcategoryEdit" name="prodcategoryEdit">
                                                @foreach($allProdCategory as $value)
                                                    <option value="{{$value->id}}">{{$value->category}}</option>
                                                @endforeach
                                            </select>
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
                            <h4 class="modal-title" id="viewName"></h4>
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

        function openModalEdit(prodID,name,hq,price, desc ,  shogun, damio, merchant, dropship , link, category,prod_cat,shogun_cost,damio_cost,merchant_cost,dropship_cost) {

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
            document.getElementById("shogunCostEdit").value = shogun_cost;
            document.getElementById("damioCostEdit").value = damio_cost;
            document.getElementById("merchantCostEdit").value = merchant_cost;
            document.getElementById("dropshipCostEdit").value = dropship_cost;
            $('#categoryEdit').val(category).change();
            $('#prodcategoryEdit').val(prod_cat).change();
        }

       

        function openModalView(prodID,name, hq, price, desc , shogun, damio, merchant, dropship, link ,category,prod_cat,shogun_cost,damio_cost,merchant_cost,dropship_cost) {
            document.getElementById("viewName").innerHTML = name;
            document.getElementById("modal-body-view").innerHTML =
                "<div class='row'>" +
                "<br/>" +
                "<div class='col-sm-6'>" +
                    "<b>Actual Price: RM  </b>" + price + "<br/>" +
                    "<b>Product Name: RM </b>" + name + "<br/>" +
                    "<b>Product Cost: RM </b>" + hq + "<br/>" +
                    "<b>Shogun Cost: RM </b>" + shogun_cost + "<br/>" +
                    "<b>Damio Cost: RM </b>" + damio_cost + "<br/>" +
                    "<b>Merchant Cost: RM </b>" + merchant_cost + "<br/>" +
                    "<b>Dropship Cost: RM </b>" + dropship_cost + "<br/>" +
                    "<b>Description: </b>" + desc + "<br/>" +
                    "</div><div class='col-sm-6'>" +
                    "<b>Profit Shogun: </b> RM " + shogun + "<br/>" +
                    "<b>Profit Damio: </b> RM " + damio + "<br/>" +
                    "<b>Profit Merchant: </b> RM " + merchant + "<br/>" +
                    "<b>Profit Dropship: </b> RM " + dropship + "<br/>" +
                "</div>";
            "</div>";
        }

    </script>
@endsection
