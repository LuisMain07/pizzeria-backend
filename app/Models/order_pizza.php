<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_pizza extends Model
{
    use HasFactory;
    protected $table = 'orders_pizza';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'pizza_size_id',
        'quantity',
    ];

     public function orders()
    {
        return $this->belongsTo(order::class, 'order_id');
    }

    public function pizzaSize()
    {
        return $this->belongsTo(Pizza_size::class, 'pizza_size_id');
    }

    // Relación temporal mientras no existan las otras tablas
    public function branch()
    {
        return $this->belongsTo(Branche::class, 'branch_id');
    }
}
