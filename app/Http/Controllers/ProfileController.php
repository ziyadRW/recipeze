<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function register(Request $request)
    {
        if ($request->is('api/*')) {
            return response()->json(['message' => 'API access is not allowed for this route.'], 403);
        }
        return view('profile.register');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:18|string',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|string',
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $form = $validator->validated();
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

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $form = $request->only('email', 'password');

        if (auth()->attempt($form)) {
            $user = $request->user();
            $token = $user->createToken('API Token')->plainTextToken;
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'User Logged In',
                    'token' => $token,
                    'user' => $user
                ]);
            }
            $request->session()->regenerate();
            return redirect(route('home'))->with('successToaster', 'User Logged In');
        }

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request){
        if ($request->is('api/*') || $request->expectsJson()) {
            $user = $request->user();
            if ($user) {
                $user->tokens()->delete();
            }
            return response()->json(['message' => 'User Logged Out'], 200);
        }
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))->with('infoToaster', 'User Logged out');
    }

    public function show(Request $request){
        $user = auth()->user();
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Profile Info',
                'user' => $user
            ]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Profile updated successfully.',
                'user' => $user
            ], 200);
        }

        return redirect()->route('profile.show')->with('successToaster', 'Profile updated successfully.');
    }

}
