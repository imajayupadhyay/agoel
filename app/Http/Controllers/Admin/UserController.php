<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserPasswordRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());

        $users = User::query()
            ->where(function ($query) {
                $query->where('is_admin', true)->orWhere('email', 'admin@gmail.com');
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'adminCount' => $this->adminUsersCount(),
        ]);
    }

    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        User::query()->create([
            ...$request->validated(),
            'is_admin' => true,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Administrator created.');
    }

    public function update(UpdateAdminUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->update([
            ...$data,
            'is_admin' => true,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Administrator details updated.');
    }

    public function updatePassword(UpdateAdminUserPasswordRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Password reset.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        if ($user->isAdmin() && $this->adminUsersCount() <= 1) {
            return back()->withErrors(['user' => 'At least one administrator account is required.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Administrator deleted.');
    }

    private function adminUsersCount(): int
    {
        return User::query()
            ->where('is_admin', true)
            ->orWhere('email', 'admin@gmail.com')
            ->count();
    }
}
