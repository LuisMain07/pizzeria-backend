<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // ✅ Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
