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

        // $remarks = CourseEvalRemark::
        //     // where('isActive', 1)
        //     orderBy('id', 'asc')
        //     ->get();

        // //HEADER
        // $parameters = CourseEvalParameter::select('id', 'name', 'desc')
        // ->where('isActive', 1)
        // ->orderBy('id', 'asc')
        // ->get();

        // //QUESTIONS
        // $statements = CourseEvalStatement::select('id', 'statement', 'parameterID')
        // ->where('isActive', 1)
        // ->orderBy('id', 'asc')
        // ->get();


        // //RATINGS/CHOICES
        // $ratings = CourseEvalRating::select('id', 'deescription', 'rating')
        // ->where('isActive', 1)
        // ->orderBy('id', 'asc')
        // ->get();

        // return view('CourseEvals.Index', compact('remarks', 'parameters', 'statements', 'ratings'));

        $remarks = CourseEvalRemark::select('id', 'question', 'placeHolder')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('parameterID');

        // Fetch parameters (headers)
        $parameters = CourseEvalParameter::select('id', 'name', 'desc')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get();

        // Fetch questions and group by parameterID
        $statements = CourseEvalStatement::select('id', 'statement', 'parameterID', 'ratingTemplateID')
            ->where('isActive', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('parameterID');

        // Fetch ratings/choices and group by evalTemplateID
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
