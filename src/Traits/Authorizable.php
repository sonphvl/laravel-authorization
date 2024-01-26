<?php

namespace Sonphvl\Authorization\Traits;

use Sonphvl\Authorization\Models\Role;

trait Authorizable
{
    /**
     * The roles that belong to the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Determine if the authenticated user has a certain permission.
     *
     * @return bool
     */
    public function hasPermission($permissionName)
    {
        if ($this->role) {
            if (optional($this->role->permissions)->pluck('name')->contains($permissionName)) {
                return true;
            }
        }
        return false;
    }
}