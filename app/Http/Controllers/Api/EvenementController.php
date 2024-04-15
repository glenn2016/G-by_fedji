<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    //
    function index (){
        $totalEvenement = Evenement::all();
        return response()->json([
            'role'=> $totalEvenement,
            'status'=>200
        ]);
    }
    public function create(Request $request){
        $validatedData = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:355'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
        ]);
        $Evenement = new Evenement();
        $Evenement->titre = $validatedData['titre'];
        $Evenement->description = $validatedData['description'];
        $Evenement->date_debut = $validatedData['date_debut'];
        $Evenement->date_fin = $validatedData['date_fin'];
        $Evenement->save();
        return response()->json([
            'message' => 'Evenement créé avec succès',
            'Evenement' => $Evenement,
        ], 200);
    }   
    public function show($id){
        return response()->json([
            'Evenement' => Evenement::find($id),
            'message' => 'Evenement recuperer',
            'status' => 200
        ]);
    }  
}
