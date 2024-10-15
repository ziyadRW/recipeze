<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function register(Request $request){
        if ($request->is('api/*')) {
            return response()->json(['message' => 'API access is not allowed for this route.'], 403);
        }
        return view('profile.register');
    }

    public function registerUser(Request $request){
        $form = $request->validate([
            'name' => 'required|min:3|max:18|string',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|string',
        ]);

        $form['password'] = bcrypt($form['password']);
        $user = User::create($form);
        $token = $user->createToken('auth_token')->plainTextToken;
        auth()->login($user);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'User Created and logged in',
                'user' => $user,
                'token' => $token
            ], 201);
        }

        return redirect(route('home'))->with('successToaster', 'User Created and logged in');
    }

    public function login(Request $request){
        if ($request->is('api/*')) {
            return response()->json(['message' => 'API access is not allowed for this route.'], 403);
        }
        return view('profile.login');
    }

    public function loginUser(Request $request){
        $form = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($form)) {
            $request->session()->regenerate();
            if ($request->is('api/*')) {
                return response()->json(['message' => 'User Logged In']);
            }
            return redirect(route('home'))->with('successToaster', 'User Logged In');
        }

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->is('api/*') || $request->expectsJson()) {
            auth()->logout();
            return response()->json(['message' => 'User Logged Out']);
        }


        return redirect(route('home'))->with('infoToaster', 'User Logged out');
    }

    public function show(Request $request){
        if ($request->is('api/*')) {
            return response()->json(auth()->user());
        }

        return view('profile.show');
    }

    public function edit(Request $request){
        if ($request->is('api/*')) {
            return response()->json(['message' => 'API access is not allowed for this route.'], 403);
        }
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

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Profile updated successfully.', 'user' => $user]);
        }

        return redirect()->route('profile.show')->with('successToaster', 'Profile updated successfully.');
    }
}
