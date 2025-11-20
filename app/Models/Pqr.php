<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pqr extends Model
{
    protected $table = 't_pqrs';
    protected $primaryKey = 'id_pqrs';
    protected $casts = [
    'fecha_creacion' => 'datetime',
    ];

    protected $fillable = [
        'numero_radicado',
        'descripcion',
        'id_users',
        'id_gestor',
        'id_tipo',
        'id_estado',
        'descripcion',
        'asunto',
    ];

    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class, 'id_users');
    }

    public function gestor(){
        return $this->belongsTo(User::class, 'id_gestor');
    }

    public function tipo(){
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function archivo()
    {
        return $this->hasMany(Archivo::class, 'id_pqr');
    }

    public function historial()
    {
        return $this->hasMany(Historial::class, 'id_pqrs', 'id_pqr');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    
    
}