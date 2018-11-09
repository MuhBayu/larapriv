<?php

namespace MuhBayu\LaraPriv\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
   protected $table;
   public function __construct() {
      $this->table = config('larapriv.table_privileges');
   }
}
