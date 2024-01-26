<?php

namespace Sonphvl\Authorization\Traits;

trait Authorizable
{
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
