<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'admin 1',
            'email' => 'admin123@gmail.com',
            'email_verified_at' => 123,
            'password'=>Hash::make('123456'),
            'remember_token'=>123,
        ]);
    }
}
