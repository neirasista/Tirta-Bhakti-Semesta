<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorController extends Controller
{
    public function store(Request $request){
        $data = $request->validate(['visitor_id'=>'required|string','ip'=>'nullable','user_agent'=>'nullable']);
        $v = Visitor::create([
            'visitor_id'=>$data['visitor_id'],
            'ip'=>$request->ip(),
            'user_agent'=>$request->header('User-Agent')
        ]);
        return response()->json($v,201);
    }

    public function countUnique(){ return response()->json(['unique_visitors'=>Visitor::distinct('visitor_id')->count('visitor_id')]); }
}
