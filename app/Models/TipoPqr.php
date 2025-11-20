<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPqr extends Model
{
    protected $table = 't_tipo_pqrs';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;
}
