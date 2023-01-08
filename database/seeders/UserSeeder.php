<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<100;$i++){
            User::create([
                'name' => 'Nhân viên '.($i+1),
                'email' => 'test'.($i+1).'@gmail.com',
                'password'=>Hash::make('123456'),
            ]);
        }
    }
}
