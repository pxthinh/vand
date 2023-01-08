<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoresAndProducts;

class StoreAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ( $i = 1; $i < 100; $i++) {
            $store = new StoresAndProducts();
            $store->store_id= rand(1,20);
            $store->product_id = rand(1,99);
            $store->save();
        }
    }
}
