<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stores;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ["Amazon", "Yahoo", "Rakuten","Tiki","Lazada"];
        $type= ["S","A"];
        for ( $i = 1; $i < 100; $i++) {
            $store = new Stores();
            $store->user_id=rand(1,10);
            $store->store_name = $array[rand(0,3)];
            $store->store_address="diachi".$i;
            $store->type=$type[rand(0,1)];
            $store->save();
        }
    }
}
