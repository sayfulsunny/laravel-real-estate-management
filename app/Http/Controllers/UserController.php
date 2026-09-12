<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        return view('pages.users.user-profile', ['user' => auth()->user()]);
    }

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $user = new User();
        return view('pages.users.create' ,compact('roles', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'mobile_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
        ]);

        // Assign role
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first(); 
        return view('pages.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|min:6',
            'role' => 'required|string',
            'mobile_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync role
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
