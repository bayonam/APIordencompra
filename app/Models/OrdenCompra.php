<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenescompra';
     /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'idOrdenC';
}
