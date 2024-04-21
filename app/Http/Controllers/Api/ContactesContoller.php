<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacte;

class ContactesContoller extends Controller
{
    //

    function index()
    {
        $evenements = Contacte::where('etat', 1)->get();
        return response()->json([
            'Contactes' => $evenements,
            'status' => 200
        ]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
        ]);
    
        $contacte = new Contacte();
        $contacte->nom = $validatedData['nom'];
        $contacte->prenom = $validatedData['prenom'];
        $contacte->email = $validatedData['email'];
        $contacte->telephone = $validatedData['telephone'];
        $contacte->message = $validatedData['message'];
        $contacte->save();
    
        return response()->json([
            'message' => 'contacte créé avec succès',
            'contacte' => $contacte,
        ], 200);
    }

    public function show($id){
        return response()->json([
            'contacte' => Contacte::find($id),
            'message' => 'contacte recuperer',
            'status' => 200
        ]);
    }

    function delete($id)
    {
        $contacte = Contacte::find($id);

        if ($contacte) {
            $contacte->etat = 0;
            $contacte->save();

            return response()->json([
                'message' => 'contacte soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'contacte not found',
                'status' => 404
            ], 404);
        }
    }
}
