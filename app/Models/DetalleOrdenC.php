<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenC extends Model
{
    use HasFactory;

    protected $table = 'detalleordenesc';

        /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'idDetalleOC';
}
