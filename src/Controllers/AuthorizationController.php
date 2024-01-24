<?php

namespace Sonphvl\Authorization\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sonphvl\Authorization\Models\Role;
use Illuminate\Support\Facades\Session;
use Sonphvl\Authorization\Models\Permission;

class AuthorizationController extends Controller
{
    public function index()
    {
        $roles       = Role::with('permissions')->get();
        $permissions = Permission::paginate(15);

        return view('authorization::authorization', compact('permissions', 'roles'));
    }

    public function update(Request $request)
    {
        try {
            $postData = $request->all();
            foreach ($postData as $roleId => $permissionArr) {
                $attach = array_filter($permissionArr, function ($data) {
                    return $data == true;
                });
                $detach = array_filter($permissionArr, function ($data) {
                    return $data != true;
                });
                $role = Role::find($roleId);
                $role->permissions()->attach(array_keys($attach));
                $role->permissions()->detach(array_keys($detach));
            }
            // Add a success flash message
            Session::flash('success', 'Your success message here.');

            // Redirect back or to another route
            // return redirect()->back();
            return redirect()->route('users.index')
                ->with('success', __('Authorization was successful!'));
        } catch (Exception $e) {
            return back()
                ->with('error', __('Authorization was not successful!'));
        }
    }
}
