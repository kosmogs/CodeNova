<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 't_rol';
    protected $primaryKey = 'id_rol';

    public $timestamps = false; // si no usas created_at / updated_at

    protected $fillable = ['nombre_rol'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_rol', 'id_rol');
    }
}
