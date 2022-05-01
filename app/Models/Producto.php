<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

        /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'idProducto';
}
