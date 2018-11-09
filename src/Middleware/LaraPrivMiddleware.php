<?php

namespace MuhBayu\LaraPriv\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MuhBayu\LaraPriv;
class RolesPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $superadmin_prefix;
    public function __construct() {
      $this->superadmin_prefix = config('larapriv.superadmin_prefix_allowed');
    }
    public function handle($request, Closure $next)
    {
      $prefix_real = basename($request->route()->getPrefix());
      $route_name = \Request::route()->getName();
      $prefix = LaraPriv::getPrefix();
      $priv = Auth()->user()->privilege_id;
	  if(!is_null($priv)) {
		$super_admin = Auth()->user()->privilege->is_superadmin;
	  }  
      $moduls = LaraPriv::getRoles();
      // $moduls = DB::table(config('larapriv.table_moduls_as'))->leftJoin(config('larapriv.table_permissions_as'), 'pp.privilege_moduls_id', '=', 'pm.id')->where('prefix', $prefix['real'])->where('pp.privilege_id', $priv)->first();
      if(in_array($prefix['basename'], $this->superadmin_prefix) && !$super_admin) return $this->redirectErrorAccess();
      $is_json = true;
      // dd($prefix);
      switch ($request->method()) {
         case 'GET':default:
            $col = 'is_read'; $is_json = false;
            break;
         case 'POST':
            $col = 'is_create';
            break;
         case 'PUT':
            $col = 'is_edit';
            break;
         case 'DELETE':
            $col = 'is_delete';
            break;
      }
      if (str_is('add_*',$route_name)) {
         $col1 = 'is_create';
      } elseif (str_is('edit_*', $route_name)) {
         $col1 = 'is_edit';
      }
      if ($moduls) {
         if (!empty($col1)) {
            if($moduls->{$col1} == '0') return $this->redirectErrorAccess();
         } else {
            if ($moduls->{$col} == '0') {
               if ($is_json) return response()->json(['success' => false, 'message' => 'Privileges not allowed']);
               return $this->redirectErrorAccess();
            }
         }
      }
      return $next($request);
    }

    /**
     * @return redirect
     */
    protected function redirectErrorAccess() {
      return redirect('/management')->withErrors(['error_msg' => 'You have no access']);
   }
}
