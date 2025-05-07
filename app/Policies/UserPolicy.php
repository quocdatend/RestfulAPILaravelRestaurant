<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // Cho phép admin xem bất kỳ user nào
    public function view(User $currentUser, User $targetUser)
    {
        return $currentUser->isAdmin() || $currentUser->id === $targetUser->id;
    }

    // Chỉ admin mới có quyền chỉnh sửa người dùng khác
    public function update(User $currentUser, User $targetUser)
    {
        return $currentUser->isAdmin() || $currentUser->id === $targetUser->id;
    }

    // Chỉ admin mới có quyền xóa user
    public function delete(User $currentUser, User $targetUser)
    {
        return $currentUser->isAdmin();
    }
}