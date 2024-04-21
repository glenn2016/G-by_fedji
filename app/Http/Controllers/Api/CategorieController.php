<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use Exception;


class CategorieController extends Controller
{
    //
    function index()
    {
        $categories = Categorie::where('etat', 1)->get();
    
        return response()->json([
            'categories' => $categories,
            'status' => 200
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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $Categorie = Categorie::findOrFail($id);

        $Categorie->nom = $validatedData['nom'];
    
        $Categorie->save();

        return response()->json([
            'message' => 'Categorie mise à jour avec succès',
            'Categorie' => $Categorie,
            'status'=>200
        ]);
    }


    function delete($id)
    {
        $categorie = Categorie::find($id);

        if ($categorie) {
            $categorie->etat = 0;
            $categorie->save();

            return response()->json([
                'message' => 'Categorie soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Categorie not found',
                'status' => 404
            ], 404);
        }
    }
}
