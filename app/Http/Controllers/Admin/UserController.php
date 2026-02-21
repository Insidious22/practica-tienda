<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateUserAction;
use App\Actions\Admin\DeleteUserAction;
use App\Actions\Admin\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use DomainException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly DeleteUserAction $deleteUserAction
    ) {
        $this->middleware(function ($request, $next) {
            if (! $request->user() || ! $request->user()->isSuperAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'No tienes permiso para acceder a esta seccion.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $users = User::with('roles')
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $this->createUserAction->execute($data, (int) $request->user()->id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        $user->load('roles', 'salesOrders', 'purchaseOrders');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $this->updateUserAction->execute($user, $data, (int) $request->user()->id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user)
    {
        try {
            $this->deleteUserAction->execute($user, $request->user());
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
