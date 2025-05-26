<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_extra_ingredient extends Model
{
    use HasFactory;
    protected $table = 'order_extra_ingredient';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

