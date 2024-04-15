<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    function index (){
        $totalRole = Role::all();
        return response()->json([
            'role'=> $totalRole,
            'status'=>200
        ]);
    }

    
}