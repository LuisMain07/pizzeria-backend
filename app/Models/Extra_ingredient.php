<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra_ingredient extends Model
{
    use HasFactory;
    protected $table = 'extra_ingredients';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

