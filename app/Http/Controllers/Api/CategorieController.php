<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use Exception;


class CategorieController extends Controller
{
    //
    function index (){
        $totalCategorie = Categorie::all();
        return response()->json([
            'categorie'=> $totalCategorie,
            'status'=>200
        ]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);
        $Categorie = new Categorie();
        $Categorie->nom = $validatedData['nom'];
        $Categorie->save();
        return response()->json([
            'message' => 'Categorie créé avec succès',
            'Categorie' => $Categorie,
        ], 200);
    }

    public function show($id){
        return response()->json([
            'Categorie' => Categorie::find($id),
            'message' => 'Categorie recuperer',
            'status' => 200
        ]);
    }   
}
