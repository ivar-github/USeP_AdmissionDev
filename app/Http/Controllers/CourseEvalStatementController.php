<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalStatement;

class CourseEvalStatementController extends Controller
{
 
    public function index()
    {
            $statements = CourseEvalStatement::
            // where('isActive', 1)
            orderBy('id', 'asc')  
            ->get();
    
            return view('CourseEvals.Statements.Index', compact('statements'));
    }

 
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

 
    public function show(string $id)
    {
        //
    }

 
    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
        //
    }

 
    public function destroy(string $id)
    {
        //
    }
}
