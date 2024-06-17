<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function getMenu()
    {
        $data = Menu::orderBy('menu')->where('status', '1')->get();
        return response()->json(['data' => $data], 200);
    }

    public static function getRole($user_id)
    {
        $data = Role::select('roles_assigned')->where('user_id', $user_id)->where('status', '1')->first()->toArray();
        return $data;
    }

    public static function getRow($user_id)
    {
        $data = Role::select('id')->where('user_id', $user_id)->where('status', '1')->first();

        return $data;
    }

    public static function assignRole($id)
    {
        $data = Role::select('roles_assigned')->where('id', $id)->where('status', '1')->first()->toArray();
        $res = explode(",", $data['roles_assigned']);
        return $res;
    }

    public static function getLowestPrice()
    {
        $data = Menu::distinct()->where('status', '1')->get(['menu'])->toArray();

        return $data;
    }

    public static function getSubMenu($menu)
    {
        $data = Menu::select('id', 'menu_icon', 'submenu', 'link')->where('menu', $menu)->where('status', '1')->get()->toArray();

        return $data;
    }

    public static function getIcon($menu)
    {
        $data = Menu::select('menu_icon')->where('menu', $menu)->where('status', '1')->first();

        return $data;
    }

    public function user()
    {
        //$data=Admin::select('id','name')->get();
        $userIds = Role::pluck('user_id')->all();
        $data = Admin::whereNotIn('id', $userIds)->select('id', 'name')->get();

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function userall()
    {
        $data = Admin::select('id', 'name')->get();


        return response()->json([
            'data' => $data
        ], 200);
    }

    public function index()
    {
        $data = DB::table('roles')->leftjoin('admins', 'admins.id', '=', 'roles.user_id')->select('roles.id', 'roles.role_name', 'admins.name', 'roles_assigned')->get();

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, []);
        $jt = Admin::select('job_title')->where('id', $request->user_id)->first();

        $lastRoleId = Role::select('id')->orderBy('id', 'DESC')->first();

        $role = new Role();
        $role_arr = $request->roles_assigned;
        $role_str = implode(",", $role_arr);
        $role->user_id = $request->user_id;
        $role->role_name = $jt->job_title;
        $role->roles_assigned = $role_str;
        $role->rid = 'R-' .($lastRoleId->id + 1);

        $role->save();
    }

    public function edit($id)
    {
        $data = Role::select('id', 'user_id')->where('id', $id)->first();
        $data1 = Role::find($id);
        $rol_arr = explode(",", $data1['roles_assigned']);

        //$data=unset($data[roles_assigned]);
        /* $menu=array();
         foreach ($rol_arr as  $va) {
           $m=Menu::orderBy('menu')->where('id',$va)->where('status','1')->get();  
           array_push($menu,$m);
         }*/
        return response()->json([
            'data' => $data,
            'rol_arr' => $rol_arr
        ], 200);
    }

    public function update(Request $request, $id, $roles)
    {
        $this->validate($request, []);

        $role = Role::find($id);

        $role->roles_assigned = $roles;

        $role->save();
    }
}
