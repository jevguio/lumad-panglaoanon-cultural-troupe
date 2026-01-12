<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('type', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }
public function upload(Request $request)
{
    $request->validate([
        'profile_img' => 'required|image|max:2048', // max 2MB
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_img')) {
        $path = $request->file('profile_img')->store('profile_images', 'public');

        $user->profile_img = $path;
        $user->save();
    }

    return back()->with('success', 'Profile image updated!');
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'type');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User removed successfully.');
    }
}
