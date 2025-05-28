<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'address',
    ];

    //Relaciones

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function ordersPizza()
    {
        return $this->hasMany(Order_pizza::class, 'branch_id');
    }

}
