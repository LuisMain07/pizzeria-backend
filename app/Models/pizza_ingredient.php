<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza_ingredient extends Model
{
    use HasFactory;
    
    protected $table = 'pizza_ingredient';
    protected $primaryKey = 'id';
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'pizza_id',
        'ingredient_id'
    ];
    
    // Relaciones
    public function pizza()
    {
        return $this->belongsTo(Pizza::class, 'pizza_id');
    }
    
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
    
    // Scope para obtener con relaciones
    public function scopeWithRelations($query)
    {
        return $query->with(['pizza', 'ingredient']);
    }
}