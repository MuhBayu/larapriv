<?php

if (!function_exists('has_menu_access')) {
   function has_menu_access($privilege_id, $prefix) {
      return @\MuhBayu\LaraPriv::has_modul_access(Auth()->user()->privilege_id, $prefix)->is_read;
   }
}
if (!function_exists('LaraPriv')) {
   function LaraPriv() {
      return new \MuhBayu\LaraPriv;
   }
}