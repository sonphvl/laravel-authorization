<?php

namespace Sonphvl\Authorization\Controllers;

use App\Http\Controllers\Controller;
use Sonphvl\Authorization\Models\Permission;
use Sonphvl\Authorization\Models\Role;

class AuthorizationController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        $permissions = Permission::get();

        dump($permissions->toArray());

        return view('authorization::authorization', compact('permissions', 'roles'));
    }
}
