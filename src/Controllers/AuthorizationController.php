<?php

namespace Sonphvl\Authorization\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sonphvl\Authorization\Models\Role;
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
            $postData = $request->except('_token');
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

            return redirect()->back()->with('success', __('Authorization was successful!'));
        } catch (Exception $e) {
            return back()
                ->with('error', __('Authorization was not successful!'));
        }
    }
}
