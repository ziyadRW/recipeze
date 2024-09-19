<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function register(){
        return view('profile.register');
    }
    public function registerUser(Request $request){
        $form= $request->validate([
            'name'=> 'required|min:3|max:18|string',
            'email'=> 'required|email|max:255|unique:users',
            'password'=> 'required|confirmed|min:8|string',
        ]);

        $form['password']= bcrypt($form['password']);
        $user= User::create($form);
        auth()->login($user);

        return redirect(route('home'))->with('successToaster', 'User Created and logged in');
    }
    public function login(){
        return view('profile.login');
    }
    public function loginUser(Request $request){
        $form= $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        if(auth()->attempt($form)){
            $request->session()->regenerate();
            return redirect(route('home'))->with('successToaster', 'User Logged In');
        }
        return back()->withErrors(['email'=> 'invalid Credentials'])->onlyInput('email');
    }
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))->with('infoToaster', 'User Logged out');
    }
    public function show(){
        return view('profile.show');
    }
    public function edit(){
        return view('profile.edit');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('successToaster', 'Profile updated successfully.');
    }

}
