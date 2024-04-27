<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SettingPolicy extends BasePolicy
{
    public function general(User $user)
    {
        return $user->hasPermissions(['view-general-settings']);
    }

    public function security(User $user)
    {
        return $user->hasPermissions(['view-security-settings']);
    }
}
