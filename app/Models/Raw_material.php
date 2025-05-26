<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raw_material extends Model
{
    use HasFactory;
    protected $table = 'raw_materials';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
