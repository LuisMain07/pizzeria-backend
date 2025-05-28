<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_extra_ingredient extends Model
{
    use HasFactory;
    protected $table = 'order_extra_ingredient';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'order_pizza_id',
        'extra_ingredient_id',
        'quantity',
    ];

    public function orders()
    {
        return $this->belongsTo(Order_pizza::class, 'order_pizza_id');
    }
    public function extraIngredient()
    {
        return $this->belongsTo(Extra_ingredient::class, 'extra_ingredient_id');
    }
}

