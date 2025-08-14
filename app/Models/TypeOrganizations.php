<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOrganizations extends Model
{
    //
        // Nombre de la conexión definida en .env y config/database.php
    protected $connection = 'mysqlapi';

    // Nombre exacto de la tabla
    protected $table = 'type_organizations';
}
