<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 't_historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;
    
    public function usuario()
    {
            return $this->belongsTo(User::class, 'id_users', 'id');
        }

        public function pqr()
        {
            return $this->belongsTo(Pqr::class, 'id_pqrs', 'id_pqr');
    }
}
