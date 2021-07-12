<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\User;
use App\Rules\IsSchoolClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc');


		if ($request->filled('q')) {
			$users = $users->where('name', 'like', "%{$request->get('q')}%")
				->orWhere('email', 'like', "%{$request->get('q')}%")
                ->orWhere('code', 'like', "%{$request->get('q')}%");
		}

        return view('admin.user.manager', ["users" => $users->paginate(15)->withQueryString()]);
    }

    public function edit(User $user)
    {
        $roles = Role::all(['name', 'string'])->toJson();
        return view('admin.user.edit', ["user" => $user,  'roles' => $roles]);
    }

    public function show(User $user)
    {
        return view('admin.user.detail', ["user" => $user]);
    }

    public function findUserByCodeOrEmail(string $identification) {
        return User::where('code', $identification)
            ->orWhere('email', $identification)
            ->with('role', 'borrows', 'reservations')
            ->firstOrFail();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return ['success' => true, 'message' => 'Uživatel byl smazán'];
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string|min:6',
            'role' => 'sometimes|exists:roles,string',
            'code' => "sometimes|unique:users,code,{$user->id}",
            'school_class' => ['sometimes', 'nullable', new IsSchoolClass()],
        ]);

        $user->update($request->only(['code','name','school_class']));
		if ($request->has('role')) {
			$user->role()->associate(Role::byString($request->role))->save();
		}

        return $user;
    }
}
