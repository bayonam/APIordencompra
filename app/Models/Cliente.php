<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
   /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'idCliente';
}
