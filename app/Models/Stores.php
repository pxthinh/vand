<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Stores extends Model
{
    use HasFactory, SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Products::class,'stores_and_products','store_id','product_id');
    }
}
