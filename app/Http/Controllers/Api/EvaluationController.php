<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    //

    function index()
    {
        $evaluations = Evaluation::where('etat', 1)->get();
        return response()->json([
            'evaluations' => $evaluations,
            'status' => 200
        ]);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'evaluer_id' => ['required', 'numeric'],
            'question_one' => ['required', 'string', 'max:55'],
            'question_deux' => ['required', 'string', 'max:455'],
            'question_trois' => ['required', 'string', 'max:455'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        $validatedData = $validator->validated();
    
        $user_id = Auth::id();
        $Evaluation = new Evaluation();
        $Evaluation->evaluateur_id = $user_id;
        $Evaluation->evaluer_id = $validatedData['evaluer_id'];
        $Evaluation->question_one = $validatedData['question_one'];
        $Evaluation->question_deux = $validatedData['question_deux'];
        $Evaluation->question_trois = $validatedData['question_trois'];
        $Evaluation->save();
        return response()->json([
            'message' => 'Evaluation créé avec succès',
            'Evaluation' => $Evaluation,
        ], 200);
    }

    public function show($id){
        return response()->json([
            'Evaluation' => Evaluation::find($id),
            'message' => 'Evaluation recuperer',
            'status' => 200
        ]);
    }


    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'evaluer_id' => ['required', 'numeric'],
            'question_one' => ['required', 'string', 'max:55'],
            'question_deux' => ['required', 'string', 'max:455'],
            'question_trois' => ['required', 'string', 'max:455'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        $validatedData = $validator->validated();
    
        $user_id = Auth::id();
        $evaluation = Evaluation::find($id);
        $evaluation->evaluateur_id = $user_id;
        $evaluation->evaluer_id = $validatedData['evaluer_id'];
        $evaluation->question_one = $validatedData['question_one'];
        $evaluation->question_deux = $validatedData['question_deux'];
        $evaluation->question_trois = $validatedData['question_trois'];
        $evaluation->save();
    
        return response()->json([
            'message' => 'Evaluation mise à jour avec succès',
            'Evaluation' => $evaluation,
        ], 200);
    }


    function delete($id)
    {
        $evaluation = Evaluation::find($id);

        if ($evaluation) {
            $evaluation->etat = 0;
            $evaluation->save();

            return response()->json([
                'message' => 'evaluation soft deleted successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'evaluation not found',
                'status' => 404
            ], 404);
        }
    }
}
