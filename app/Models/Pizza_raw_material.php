<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza_raw_material extends Model
{
    use HasFactory;
    protected $table = 'pizza_raw_material';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
