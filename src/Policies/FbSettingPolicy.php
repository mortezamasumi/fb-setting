<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Mortezamasumi\FbSetting\Models\FbSetting;

class FbSettingPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->can('view_any_fb::setting');
    }

    public function view($user, FbSetting $fbSetting): bool
    {
        return $user->can('view_fb::setting');
    }

    public function create($user): bool
    {
        return $user->can('create_fb::setting');
    }

    public function update($user, FbSetting $fbSetting): bool
    {
        return $user->can('update_fb::setting');
    }

    public function delete($user, FbSetting $fbSetting): bool
    {
        return $user->can('delete_fb::setting');
    }

    public function deleteAny($user): bool
    {
        return $user->can('delete_any_fb::setting');
    }

    public function forceDelete($user, FbSetting $fbSetting): bool
    {
        return $user->can('force_delete_fb::setting');
    }

    public function forceDeleteAny($user): bool
    {
        return $user->can('force_delete_any_fb::setting');
    }

    public function restore($user, FbSetting $fbSetting): bool
    {
        return $user->can('restore_fb::setting');
    }

    public function restoreAny($user): bool
    {
        return $user->can('restore_any_fb::setting');
    }

    public function replicate($user, FbSetting $fbSetting): bool
    {
        return $user->can('replicate_fb::setting');
    }

    public function reorder($user): bool
    {
        return $user->can('reorder_fb::setting');
    }
}
