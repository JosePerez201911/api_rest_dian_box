<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipalities extends Model
{
    //
    protected $connection = 'mysqlapi';

    // Nombre exacto de la tabla
    protected $table = 'municipalities';
}
