<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\Purchase;
use App\Product;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
    {

        $products = DB::table('products')->get();

        $allTypeProdCat = DB::table('products_category')->get();

        return view(
            'masteradmin/products',
            [
                'product' => $products,
                'allTypeProdCat' => $allTypeProdCat
            ]
        );
    }

    public static function getAllProdCat()
    {
        $getAll = DB::table('products_category')->get();
        return $getAll;
    }

    public function update(Request $req)
    {

        $validatedData = [
            'productNameEdit' => 'required',
            'productPriceEdit' => 'required',
            'productDescEdit' => 'required',
            'hqPriceEdit' => 'required',
            'shogunPriceEdit' => 'required',
            'dropshipPriceEdit' => 'required',
            'damioPriceEdit' => 'required',
            'merchantPriceEdit' => 'required',
            'productLinkEdit' => '',
            'categoryEdit' => 'required',
            'prodcategoryEdit' => 'required',
            'imageEdit' => 'image|mimes:jpeg,png,jpg',
            'shogunCostEdit' => 'required',
            'damioCostEdit' => 'required',
            'merchantCostEdit' => 'required',
            'dropshipCostEdit' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect('/master-manageProduct')->with('error', 'Please ensure all fields were filled and file uploaded is image files.');
        } else {
            $data = $req->input();
            try {
                if ($req->file('imageEdit') == null) {
                    DB::table('products')
                        ->where('id', $data['productIDEdit'])
                        ->update([
                            'product_name' => $data['productNameEdit'],
                            'product_price' => $data['productPriceEdit'],
                            'product_description' => $data['productDescEdit'],
                            'price_shogun' => $data['shogunPriceEdit'],
                            'price_damio' => $data['damioPriceEdit'],
                            'price_merchant' => $data['merchantPriceEdit'],
                            'price_dropship' => $data['dropshipPriceEdit'],
                            'price_hq' => $data['hqPriceEdit'],
                            'product_link' => $data['productLinkEdit'],
                            'belongToAdmin' => $data['categoryEdit'],
                            'product_cat' => $data['prodcategoryEdit'],
                            'shogun_cost' => $data['shogunCostEdit'],
                            'damio_cost' => $data['damioCostEdit'],
                            'merchant_cost' => $data['merchantCostEdit'],
                            'dropship_cost' => $data['dropshipCostEdit'],
                        ]);


                    return redirect('/master-manageProduct')->with('success', 'Product has been updated');
                } else {

                    $image = $req->file('imageEdit');
                    $newFileName = $image->getClientOriginalName();
                    $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                    $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                    if (file_exists(base_path('../public_html/imageUploaded/products/' . $image->getClientOriginalName() . ''))) {
                        $newFileName = $filename . '1' . '.' . $extension;
                        $image->move(base_path('../public_html/imageUploaded/products'), $newFileName);
                    } else {
                        $image->move(base_path('../public_html/imageUploaded/products'), $image->getClientOriginalName());
                    }

                    DB::table('products')
                        ->where('id', $data['productIDEdit'])
                        ->update([
                            'product_name' => $data['productNameEdit'],
                            'product_price' => $data['productPriceEdit'],
                            'product_description' => $data['productDescEdit'],
                            'price_shogun' => $data['shogunPriceEdit'],
                            'price_damio' => $data['damioPriceEdit'],
                            'price_merchant' => $data['merchantPriceEdit'],
                            'price_dropship' => $data['dropshipPriceEdit'],
                            'price_hq' => $data['hqPriceEdit'],
                            'product_link' => $data['productLinkEdit'],
                            'belongToAdmin' => $data['categoryEdit'],
                            'product_image' => $newFileName,
                            'product_cat' => $data['prodcategoryEdit'],
                            'shogun_cost' => $data['shogunCostEdit'],
                            'damio_cost' => $data['damioCostEdit'],
                            'merchant_cost' => $data['merchantCostEdit'],
                            'dropship_cost' => $data['dropshipCostEdit'],
                        ]);

                    return redirect('/master-manageProduct')->with('success', "Product has been updated");
                }
            } catch (Exception $e) {
                return redirect('/master-manageProduct')->with('error', "Data cannot be updated");
            }
        }
    }

    public function create(Request $req)
    {
        $validatedData = [
            'productName' => 'required',
            'productPrice' => 'required',
            'productDesc' => 'required',
            'shogunCost' => 'required',
            'damioCost' => 'required',
            'merchantCost' => 'required',
            'dropshipCost' => 'required',
            'shogunPrice' => 'required',
            'dropshipPrice' => 'required',
            'damioPrice' => 'required',
            'merchantPrice' => 'required',
            'hqPrice' => 'required',
            'productLink' => '',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'category' => 'required',
            'prod_category' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect('/master-manageProduct')->with('error', 'Please ensure all fields were filled and file uploaded is image files.');
        } else {
            $data = $req->input();
            try {

                $image = $req->file('image');
                $newFileName = $image->getClientOriginalName();
                $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                if (file_exists(base_path('../public_html/imageUploaded/products/' . $image->getClientOriginalName() . ''))) {
                    $newFileName = $filename . '1' . '.' . $extension;
                    $image->move(base_path('../public_html/imageUploaded/products'), $newFileName);
                } else {
                    $image->move(base_path('../public_html/imageUploaded/products'), $image->getClientOriginalName());
                }

                DB::table('products')->insert([
                    'product_name' => $data['productName'],
                    'product_price' => $data['productPrice'],
                    'product_description' => $data['productDesc'],
                    'price_hq' => $data['hqPrice'],
                    'product_image' => $newFileName,
                    'price_shogun' => $data['shogunPrice'],
                    'price_damio' => $data['damioPrice'],
                    'price_merchant' => $data['merchantPrice'],
                    'price_dropship' => $data['dropshipPrice'],
                    'product_link' => $data['productLink'],
                    'belongToAdmin' => $data['category'],
                    'product_cat' => $data['prod_category'],
                    'shogun_cost' => $data['shogunCost'],
                    'damio_cost' => $data['damioCost'],
                    'merchant_cost' => $data['merchantCost'],
                    'dropship_cost' => $data['dropshipCost'],
                ]);


                return redirect('/master-manageProduct')->with('success', 'Product has been created');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function delete($id)
    {
        DB::table('products')
            ->delete($id);

        return redirect('/master-manageProduct')->with('success', 'Product has been removed.');
    }

    public function viewProdCategory()
    {
        $allTypeProdCat = DB::table('products_category')->get();

        return view(
            'masteradmin/productsCat',
            [
                'allTypeProdCat' => $allTypeProdCat
            ]
        );
    }

    public function deleteCategory($id)
    {
        DB::table('products_category')->where('id', $id)->delete();
        return redirect('/master-manageProdCat')->with('success', 'Category has been deleted.');
    }

    public function addCategory(Request $req)
    {
        $validatedData = [
            'catName' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect('/master-manageProdCat')->with('error', 'Please fill in all the box before creating new category');
        } else {
            $data = $req->input();
            try {

                $image = $req->file('image');
                $newFileName = $image->getClientOriginalName();
                $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                if (file_exists(base_path('../public_html/imageUploaded/productCat/' . $image->getClientOriginalName() . ''))) {
                    $newFileName = $filename . '1' . '.' . $extension;
                    $image->move(base_path('../public_html/imageUploaded/productCat'), $newFileName);
                } else {
                    $image->move(base_path('../public_html/imageUploaded/productCat'), $image->getClientOriginalName());
                }

                DB::table('products_category')->insert([
                    'category' => $data['catName'],
                    'desc' => $data['desc'],
                    'created_at' => NOW(),
                    'image' => $newFileName
                ]);

                return redirect('/master-manageProdCat')->with('success', 'Category has been created');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function updateCategory(Request $req)
    {
        $validatedData = [
            'catNameEdit' => 'required',
            'descEdit' => 'required',
            'imageEdit' => 'image|mimes:jpeg,png,jpg,gif',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect('/master-manageProdCat')->with('error', 'Please fill in all the box before updating category');
        } else {
            $data = $req->input();
            try {
                if ($req->file('imageEdit') == null) {
                    DB::table('products_category')
                        ->where('id', $data['idEdit'])
                        ->update([
                            'category' => $data['catNameEdit'],
                            'desc' => $data['descEdit'],
                            'updated_at' => NOW()
                        ]);

                    return redirect('/master-manageProdCat')->with('success', 'Category has been updated');
                } else {
                    $image = $req->file('imageEdit');
                    $newFileName = $image->getClientOriginalName();
                    $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                    $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                    if (file_exists(base_path('../public_html/imageUploaded/productCat/' . $image->getClientOriginalName() . ''))) {
                        $newFileName = $filename . '1' . '.' . $extension;
                        $image->move(base_path('../public_html/imageUploaded/productCat'), $newFileName);
                    } else {
                        $image->move(base_path('../public_html/imageUploaded/productCat'), $image->getClientOriginalName());
                    }
                    DB::table('products_category')
                        ->where('id', $data['idEdit'])
                        ->update([
                            'category' => $data['catNameEdit'],
                            'desc' => $data['descEdit'],
                            'updated_at' => NOW(),
                            'image' => $newFileName
                        ]);

                    return redirect('/master-manageProdCat')->with('success', 'Category has been updated');
                }
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }
}
