<?php

declare(strict_types=1);

namespace Mortezamasumi\FbSetting\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;
use Mortezamasumi\FbSetting\Models\FbSetting;

class FbSettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FbSetting');
    }

    public function view(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('View:FbSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FbSetting');
    }

    public function update(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('Update:FbSetting');
    }

    public function delete(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('Delete:FbSetting');
    }

    public function restore(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('Restore:FbSetting');
    }

    public function forceDelete(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('ForceDelete:FbSetting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FbSetting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FbSetting');
    }

    public function replicate(AuthUser $authUser, FbSetting $fbSetting): bool
    {
        return $authUser->can('Replicate:FbSetting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FbSetting');
    }
}
