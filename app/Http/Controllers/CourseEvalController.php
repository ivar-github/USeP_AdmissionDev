<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalRemark;
use App\Models\CourseEvalParameter;
use App\Models\CourseEvalRating;
use App\Models\CourseEvalStatement;
use Illuminate\Validation\ValidationException;
use Exception;

class CourseEvalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $remarks = CourseEvalRemark::select('id', 'question', 'placeHolder')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('parameterID');

            
        $parameters = CourseEvalParameter::select('id', 'name', 'desc')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get();

            
        $statements = CourseEvalStatement::select('id', 'statement', 'parameterID', 'ratingTemplateID')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('parameterID');

            
        $ratings = CourseEvalRating::select('id', 'description', 'rating', 'evalTemplateID')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('evalTemplateID');

        return view('CourseEvals.Index', compact('remarks', 'parameters', 'statements', 'ratings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
