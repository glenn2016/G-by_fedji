<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class Authcontroller extends Controller     
{
    //

    // Connexion d'un utilisateur
    public function store(Request $request)
    {
        Auth::shouldUse('web');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    
            $user = User::find(Auth::user()->id);
    
            $user_token['token'] = $user->createToken('appToken')->accessToken;
    
            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
                'status' => 200,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Authentification non reussi',
            ], 401);
        }
    }

    //Listes de tout les utlisateurs participants
    
    function index (){
        $usersWithRole = User::with('roles')->get();
        $participants = $usersWithRole->filter(function ($user) {
            return $user->hasRole('participant');
        });
        return response()->json([
            'participants' => $participants,
            'status' => 200
        ]);
    }
    //Creation d'un participants
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
    
            // Attache le rôle à l'utilisateur
            $user->roles()->attach(2);
    
            // Crée un jeton d'authentification pour l'utilisateur
            $token = $user->createToken('auth_token')->accessToken;
    
            return response()->json([
                'token' => $token,      
                'type' => 'Bearer'
            ]);
        }
    }
    
    //Deconnexion d'un utlilisateur
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
    //Recuperation de l'utilisateur Connecter
    public function user()
    {
        $user = auth()->user();

          return response()->json([
            "status"=> true,
            "message"=>"information user",
            "data"=> $user
          ]);
    }
}