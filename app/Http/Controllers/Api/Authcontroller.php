<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class Authcontroller extends Controller     
{
    //

    public function store()
    {
        Auth::shouldUse('web');
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = User::find(Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
   
    function index (){
        $totalUser = User::all();
        return response()->json([
            'User'=> $totalUser,
            'status'=>200
        ]);
    }

    public function create(Request $request){

        $validations = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => 'required|string|min:8',
        ]);

        if ($validations->fails()) {
            $errors = $validations->errors();
            return response()->json([
                'errors' => $errors,
                'status' => 401
            ]);
        }

        if ($validations->passes()) {

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'categorie_id' => $request->categorie_id,
                'entreprise_id' => $request->entreprise_id,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->attach($request->role);

            $token = $user->createToken('auth_token')->accessToken;

            return response()->json([
                'token' => $token,      
                'type' => 'Bearer'
            ]);
        }
    }
    
    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }

    public function user()
    {
        if (Auth::check()) {
            // L'utilisateur est authentifié, récupérer l'utilisateur
            $user = auth()->user();
            return response()->json($user);
        } else {
            // L'utilisateur n'est pas authentifié
            return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
        }
    }

}