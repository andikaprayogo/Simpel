<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'image_path'];
    
    public function lops()
    {
        return $this->hasMany(Lop::class, 'witel', 'name');
    }
}