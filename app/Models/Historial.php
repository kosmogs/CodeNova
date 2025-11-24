<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 't_historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;
    
    protected $fillable = [
        'id_users',
        'id_pqrs',
        'descripcion',
        'fecha_registro',
        'accion',
        // agrega los demás campos que uses en create()
    ];

    public function usuario()
    {
            return $this->belongsTo(User::class, 'id_users', 'id');
        }

        public function pqr()
        {
            return $this->belongsTo(Pqr::class, 'id_pqrs', 'id_pqr');
    }
}
