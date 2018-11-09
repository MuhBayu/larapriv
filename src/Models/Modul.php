<?php

namespace MuhBayu\LaraPriv\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
   protected $table;
   public function __construct() {
      $this->table = config('larapriv.table_moduls');
   }
}
