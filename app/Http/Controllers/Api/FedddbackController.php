<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Feddback;        
use Illuminate\Support\Facades\Validator;


class FedddbackController extends Controller
{
    //

    function index()
    {
        $totalFeddbacks = Feddback::all();
        return response()->json([
            'feedbacks' => $totalFeddbacks,
            'status' => 200
        ]);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'evenement_id' => ['required', 'numeric'], // Assurez-vous que evenement_id est numérique
            'commentaire' => ['required', 'string', 'max:255'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        $validatedData = $validator->validated();
    
        $user_id = Auth::id();
        $feedback = new Feddback();
        $feedback->user_id = $user_id;
        $feedback->commentaire = $validatedData['commentaire'];
        $feedback->evenement_id = $validatedData['evenement_id'];
    
        $feedback->save();
    
        return response()->json([
            'message' => 'Feedback créé avec succès',
            'feedback' => $feedback,
        ], 200);
    }

    public function show($id){
        return response()->json([
            'Fedddbacks' => Feddback::find($id),
            'message' => 'Fedddbacks recuperer',
            'status' => 200
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'evenement_id' => ['required', 'numeric'], // Assurez-vous que evenement_id est numérique
            'commentaire' => ['required', 'string', 'max:255'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        $validatedData = $validator->validated();
    
        $user_id = Auth::id();
        $feedback = Feddback::find($id);
        $feedback->user_id = $user_id;
        $feedback->commentaire = $validatedData['commentaire'];
        $feedback->evenement_id = $validatedData['evenement_id'];
    
        $feedback->save();
    
        return response()->json([
            'message' => 'Feedback mis à jour avec succès',
            'feedback' => $feedback,
        ], 200);
    }

    
    function delete($id)
    {
        $feddback = Feddback::find($id);

        if ($feddback) {
            $feddback->etat = 0;
            $feddback->save();

            return response()->json([
                'message' => 'f5eddback soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'feddback not found',
                'status' => 404
            ], 404);
        }
    }

    

}
