<?php

namespace MuhBayu;

use MuhBayu\LaraPriv\Models\Permission as PermissionModel;
use MuhBayu\LaraPriv\Models\Modul;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * @package LaraPriv
 * @author MuhBayu <bnugraha00@gmail.com>
 * @link https://github.com/MuhBayu/larapriv
 */

class LaraPriv implements \MuhBayu\LaraPriv\LaraPrivInterface
{
   /** @var self */
   private static $instance;

   /** @var int */
   protected static $priv_id = null;

   /** @var string */
   protected $tb_moduls, $tb_privileges, $tb_permissions;


   /**
     * Constructor.
     *
     */
   private function __construct() {
      $this->tb_moduls = config('larapriv.table_moduls');
      $this->tb_privileges = config('larapriv.table_privileges');
      $this->tb_permissions = config('larapriv.table_permissions');
   }

   /**
    * @return self
    */
   public static function getInstance() {
      if (is_null(self::$instance)) {
         self::$instance = new self();
      }
      return self::$instance;
   }

   /**
    * @param int $id
    * @return $priv_id
    */
   public static function set_privilege_id($id)
   {
      return self::$priv_id = $id;
   }

   /**
    * @return array
    */
   public static function getPrefix() {
      $uri_path = request()->path();
      $prefix_basename = basename(request()->route()->getPrefix());
      $prefix_uri = substr($uri_path, strpos($uri_path, $prefix_basename), strlen($uri_path));
      if(in_array(basename($prefix_uri), ['add', 'edit'])) $prefix_uri = $prefix_basename;
      $prefix['basename'] = $prefix_basename;
      $prefix['real'] = $prefix_uri;
      return $prefix;
   }

   /**
    * @return string $prefix
    */
   public static function getPrefixSpesific() {
      $segment = null;
      $uri = request()->url();
      $prefix = basename(request()->route()->getPrefix());
      $after_prefix = substr($uri, strpos($uri, $prefix), strlen($uri));
      $after_prefix = explode('/', $after_prefix);
      if(sizeof($after_prefix) > 1) $segment = $after_prefix[1];
      if (!is_null($segment) && !in_array($segment, ['add','edit'])) {
         $prefix = $segment;
      }
      return $prefix;
   }

   /**
    * @return string $segment
    */
   public static function getSegmentAfterPrefix() {
      $uri = request()->url();
      $segment = null;
      $segment = basename(request()->path());
      $prefix = basename(request()->route()->getPrefix());
      $after_prefix = substr($uri, strpos($uri, $prefix), strlen($uri));
      $after_prefix = explode('/', $after_prefix);
      if(sizeof($after_prefix) > 1) $segment = $after_prefix[1];
      return $segment;
   }

   /**
    * @param null $role
    * @return \MuhBayu\LaraPriv\Models\Permission
    */
   public static function getRoles($role=null) {
      $prefix = Self::getPrefix();
      @$modul_id = DB::table(Self::getInstance()->tb_moduls)->where('prefix', $prefix['real'])->first()->id;
      $roles = PermissionModel::where('privilege_moduls_id', $modul_id)->first();
      if($role) return $roles->{$role};
      return $roles;
   }

   /**
    * @param string $request
    * @return array
    */
   static function generate_store_roles($request) {
      foreach ($request as $key => $roles) {
         foreach ($roles as $k => $value) {
            $priv_roles[$key] = [
               'is_create' => isset($request[$key]['create']) ? '1' : '0',
               'is_read' => isset($request[$key]['read']) ? '1' : '0',
               'is_edit' => isset($request[$key]['edit']) ? '1' : '0',
               'is_delete' => isset($request[$key]['delete']) ? '1' : '0',
               'privilege_id' => self::$priv_id,
               'privilege_moduls_id' => $key,
            ];
         }
      }
      return $priv_roles;
   }

   /**
    * @param string $request
    * @return array
    */
   static function generate_update_roles($request) {
      foreach ($request as $id_moduls => $roles) {
         foreach ($roles as $k => $value) {
            $priv_roles[$id_moduls] = (object)[
               'privilege_moduls_id' => $id_moduls,
               'privilege_id' => self::$priv_id,
               'update' => [
                  'is_create' => isset($request[$id_moduls]['create']) ? '1' : '0',
                  'is_read' => isset($request[$id_moduls]['read']) ? '1' : '0',
                  'is_edit' => isset($request[$id_moduls]['edit']) ? '1' : '0',
                  'is_delete' => isset($request[$id_moduls]['delete']) ? '1' : '0',
               ]
            ];
         }
      }
      return $priv_roles;
   }

   /**
    * Get All Moduls
    *
    * @return \MuhBayu\LaraPriv\Models\Modul
    */
   public static function all_moduls() {
      return Modul::all();
   }

   /**
    * Get All Moduls With Permissions
    *
    * @param null $privilege_id
    * @return array
    */
   public static function all_moduls_permissions($privilege_id=null) {
      $modul_roles = Modul::all();
      $modul_roles = $modul_roles->map(function ($item, $key) use($privilege_id) {
         $item->key = $item->id;
         $item->roles = PermissionModel::where(['privilege_id'=> $privilege_id, 'privilege_moduls_id' => $item->id])->first();
         return $item;
      });
      return $modul_roles;
   }
}
