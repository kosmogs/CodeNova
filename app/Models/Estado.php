<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 't_estado_pqrs'; // <-- o el nombre real de tu tabla
    protected $primaryKey = 'id_estado'; // <-- si tu PK NO es "id"
    public $timestamps = false;
}
