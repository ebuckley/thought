<?php

namespace App\Policies;

use App\Models\AssetType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssetTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AssetType $assetType): bool
    {
        if (!$assetType->team_id) return true;
        return $user->currentTeam->id == $assetType->team_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // TODO only admins can create AssetTypes
        // check the team role
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AssetType $assetType): bool
    {
        if (is_null($assetType->team_id)) return false;
        if (!$this->create($user)) {
            return false;
        }
        return $this->view($user, $assetType);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AssetType $assetType): bool
    {
        return $this->update($user, $assetType);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AssetType $assetType): bool
    {
        return $this->update($user, $assetType);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AssetType $assetType): bool
    {
        // TODO only super admins??
        return false;
    }
}
