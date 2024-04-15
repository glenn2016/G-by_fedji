<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class Authcontroller extends Controller
{
    //
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
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'type' => 'Bearer'
            ]);
        }
    }
    
    public function connexion(Request $request){

            // Authentification de l'utilisateur
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'msg' => 'Informations de connexion non reconnues',
                'status' => 401
            ]);
        }

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur a le rôle 'admin'
        if ($user->hasRole('Admin')) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'type' => 'Bearer',
                'status' => 200,
                'role' => 'admin'
                ])->cookie('jwt', $token);
            }

        // Vérifier si l'utilisateur a le rôle 'participant'
        if ($user->hasRole('Participant')) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'type' => 'Bearer',
                'status' => 200,
                'role' => 'participant'
            ])->cookie('jwt', $token);
        }

            // Si l'utilisateur n'a ni le rôle 'admin' ni le rôle 'participant'
        return response()->json([
           'msg' => 'L\'utilisateur n\'a pas de rôle défini',
            'status' => 401
        ]);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

}