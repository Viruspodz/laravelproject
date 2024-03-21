<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user->name = $validated['name'];    
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }
    
        $user->save();
        Alert::info('Success', 'User has been updated !');

        return redirect()->route('profile.edit');
    }
    
}
