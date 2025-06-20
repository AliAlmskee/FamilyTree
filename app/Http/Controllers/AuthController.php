<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function register(Request $request)
    { 
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
        ]);

        $user = new User();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = 'customer' ;

        $user->save();
        return response()->json(['message' => 'Registration successful'] , $user);
    } 


    public function login(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        if (auth()->attempt(['name' => $request->input('name'), 'password' => $request->input('password')])) {
            $user = auth()->user();
            $token = $user->createToken('AuthToken')->plainTextToken;
    
            return response()->json(['Role' => $user->role, 'token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout()
    {
        auth('sanctum')->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    public function checkAuth()
    {
        $user = auth('sanctum')->user();
        $token = $user->currentAccessToken();
        
        return response()->json([
            'authenticated' => true,
            'user' => $user->only('id', 'name', 'email', 'role'),
            'token_expiration' => $token->expires_at,
            'current_time' => now()->toDateTimeString()
        ]);
    }
    public function getAuthenticatedUserId()
    {
        return Auth::id();
    }


    public function changepassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

            User::find( $user->id)->update(['password'=>   Hash::make($request->new_password)]);
             return response()->json(['message'=> ' password changed succsefully'],200);

    }
}

