<?php
// app/Models/Branche.php - ACTUALIZAR
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    use HasFactory;

    protected $table = 'branches';
    protected $primaryKey = 'id';
    public $timestamps = true; // CAMBIAR de false a true

    protected $fillable = [
        'name',
        'address'
    ];

    // Relaciones preparadas para trabajo en equipo
    public function orders()
    {
        return $this->hasMany(Order::class, 'branch_id');
    }

    public function ordersPizza()
    {
        return $this->hasMany(Order_pizza::class, 'branch_id');
    }

}
