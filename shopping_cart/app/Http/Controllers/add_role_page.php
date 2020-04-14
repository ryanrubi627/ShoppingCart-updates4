<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class add_role_page extends Controller
{
	//USE FOR DISPLAY DATA INTO TABLE FROM DATABASE..
    public function index(){
	    $role = Role::with('permissions')->get();
		return view('add_role_page', ['roles'=>$role]);
  }

  	//ADD ROLE..
	public function add_role(Request $request){

		$role = Role::create(['name' => $request->role]);
		$permission = Permission::find($request->role_permission);
		$role->givePermissionTo($permission);
	}

	//UPDATE ROLE..
	public function update_role(Request $request){
		$id = $request->id;
		$role = $request->role;
		$permission = $request->edt_permission;

		Role::where('id', $id)
                ->update(['name' => $role]);

       	$role = Role::find($id);
       	$role->getAllPermissions();
       	$role->revokePermissionTo($role->permission);
        $role->givePermissionTo($permission);
	}

	//DELETE USER..
	public function delete_role(Request $request){
		Role::where('id', $request->id)->delete();
	}
}
