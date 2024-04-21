<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entreprise;

class EntrepriseController extends Controller
{
    //
    function index()
    {
        $entreprises = Entreprise::where('etat', 1)->get();
    
        return response()->json([
            'entreprises' => $entreprises,
            'status' => 200
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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $entreprise = Entreprise::findOrFail($id);

        $entreprise->nom = $validatedData['nom'];
    
        $entreprise->save();

        return response()->json([
            'message' => 'Entreprise mise à jour avec succès',
            'entreprise' => $entreprise,
            'status'=>200
        ]);
    }

    function delete($id)
    {
        $entreprise = Entreprise::find($id);

        if ($entreprise) {
            $entreprise->etat = 0;
            $entreprise->save();

            return response()->json([
                'message' => 'entreprise soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'entreprise not found',
                'status' => 404
            ], 404);
        }
    }
}
