<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EvenementController extends Controller
{
    //
    function index()
    {
        $evenements = Evenement::where('etat', 1)->get();
        return response()->json([
            'evenements' => $evenements,
            'status' => 200
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:355'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
        ]);
        $evenement = Evenement::findOrFail($id);

        $evenement->titre = $validatedData['titre'];
        $evenement->description = $validatedData['description'];
        $evenement->date_debut = $validatedData['date_debut'];
        $evenement->date_fin = $validatedData['date_fin'];

        $evenement->save();

        return response()->json([
            'message' => 'Evenement mis à jour avec succès',
            'Evenement' => $evenement,
        ]);
    }

    function delete($id)
    {
        $evenement = Evenement::find($id);

        if ($evenement) {
            $evenement->etat = 0;
            $evenement->save();

            return response()->json([
                'message' => 'evenement soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'evenement not found',
                'status' => 404
            ], 404);
        }
    }

}
