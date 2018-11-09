<?php

namespace MuhBayu\LaraPriv;


/**
 *
 */
interface LaraPrivInterface
{
   public static function set_privilege_id($id);
   public static function getPrefix();
   public static function getPrefixSpesific();
   public static function getSegmentAfterPrefix();
   public static function getRoles($role=null);
   public static function generate_store_roles($request);
   public static function generate_update_roles($request);
   public static function all_moduls();
   public static function all_moduls_permissions($privilege_id=null);
}

?>
