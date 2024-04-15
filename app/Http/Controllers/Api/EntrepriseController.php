<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entreprise;

class EntrepriseController extends Controller
{
    //
    function index (){
        $totalEntreprise = Entreprise::all();
        return response()->json([
            'role'=> $totalEntreprise,
            'status'=>200
        ]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);
        $Entreprise = new Entreprise();
        $Entreprise->nom = $validatedData['nom'];
        $Entreprise->save();
        return response()->json([
            'message' => 'Entreprise créé avec succès',
            'Entreprise' => $Entreprise,
        ], 200);
    }

    public function show($id){
        return response()->json([
            'Entreprise' => Entreprise::find($id),
            'message' => 'Entreprise recuperer',
            'status' => 200
        ]);
    }  
}
