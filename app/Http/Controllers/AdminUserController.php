<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderByDesc('id')
            ->get();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        $currentAdmin = $request->user();

        // 防止管理员把自己禁用，避免把自己锁在系统外
        if ($currentAdmin->id === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', __('messages.admin_users_cannot_disable_self'));
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.admin_user_status_updated'));
    }
}