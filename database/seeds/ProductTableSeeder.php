<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ["product_name"=>"Apple","product_image"=>"https://www.kofixlabs.co/logo.png","product_description"=>"Our Apple","product_price"=>"1","payment_link"=>"rtvgkhf3"],
       ];
       Product::insert($products);
    }
}
