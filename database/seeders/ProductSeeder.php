<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ["Giày", "Dép", "Quần","Áo","Nón"];
        $price= [100000,200000,300000,400000,500000,600000];
        for ( $i = 1; $i < 100; $i++) {
            $product = new Products();
            $product->product_name = $array[rand(0,3)];
            $product->product_price=$price[rand(0,5)];
            $product->description="description".$i;
            $product->save();
        }
    }
}
