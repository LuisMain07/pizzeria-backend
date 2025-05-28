<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $table = 'pizzas';

    protected $fillable = [
        'name'
    ];

    public function sizes()
    {
        return $this->hasMany(Pizza_size::class);
    }
}
