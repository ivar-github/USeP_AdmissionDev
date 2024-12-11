<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalRating;

class CourseEvalRatingController extends Controller
{
 
    public function index()
    {
        
        $ratings = CourseEvalRating::
            // where('isActive', 1)
            orderBy('id', 'asc')  
            ->get();

        return view('CourseEvals.Ratings.Index', compact('ratings'));
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
