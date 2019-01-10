<?php

namespace MuhBayu\LaraPriv\Traits;
use Illuminate\Support\Facades\Schema;

/**
 * Trait for Model Users
 */
trait HasPrivilege
{
   public function privilege()
   {
     return $this->hasOne('MuhBayu\LaraPriv\Models\Privilege', 'id', 'privilege_id');
   }
}


?>
