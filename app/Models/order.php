<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
    protected $primaryKey = 'id';
    
    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'client_id',
        'branch_id',
        'total_price',
        'status',
        'delivery_type',
        'delivery_person_id'
    ];

    // Definir las relaciones si las necesitas
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'delivery_person_id');
    }
}