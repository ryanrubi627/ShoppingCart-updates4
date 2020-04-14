<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class superAdmin_page extends Controller
{
	//USE FOR DISPLAY DATA INTO TABLE FROM DATABASE..
	public function index(){
		
	    $user = User::with('roles')->get();
	    $role = Role::all();
		return view('superAdmin_page', ['users'=>$user, 'roles'=>$role]);

	}

	//DELETE USER..
	public function delete_user(Request $request){
		$id = $request->id;
		User::where('id', $id)->delete();
	}

	//REGISTER USER..
	public function register_user(Request $request){
		$User = new User;
		$User->name = $request->name;
		$User->email = $request->email;
		$User->password = Hash::make($request->password);
		$User->save();

		$id = User::find($User->id);
		$role = $request->roles;
		$id->assignRole($role);
	}

	//UPDATE USER..
	public function update_user(Request $request){
		$id = $request->id;
		$role = $request->role;

		User::where('id', $id)
                ->update(['name' => $request->name, 'email' => $request->email]);

       	$user = User::find($id);
       	$roles = User::with('roles')->find($id);
       	$user->removeRole($roles->roles[0]->name);
        $user->assignRole($role);
	}
}
