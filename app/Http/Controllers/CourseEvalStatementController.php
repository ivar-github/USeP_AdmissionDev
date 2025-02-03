<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalStatement;
use App\Models\CourseEvalParameter;
use App\Models\CourseEvalRating;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;

class CourseEvalStatementController extends Controller
{

    public function index()
    {

        $statements = CourseEvalStatement::
        // where('isActive', 1)
        orderBy('id', 'asc')
        ->get();

        $parameters = CourseEvalParameter::select('id', 'name', 'desc')
        ->where('isActive', 1)
        ->orderBy('id', 'asc')
        ->get();

        $ratings = CourseEvalRating::select('id', 'description', 'rating', 'sortOrder', 'evalTemplateID')
        ->where('isActive', 1)
        ->orderBy('evalTemplateID', 'asc')
        ->orderBy('id', 'asc')
        ->get()
        ->groupBy('evalTemplateID');


        return view('CourseEvals.Statements.Index', compact('statements', 'parameters', 'ratings'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'Statement' => ['required', 'string', 'max:255'],
                'SortOrder' => ['required', 'integer', 'max:100'],
                'Parameter_ID' => ['required', 'integer', 'max:500'],
                'EvalType_ID' => ['required', 'integer', 'max:500'],
                'Version_ID' => ['required', 'integer', 'max:10'],
                'RatingTemplate_ID' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $statement = CourseEvalStatement::create([
                'statement' => $request->Statement,
                'sortOrder' => $request->SortOrder,
                'parameterID' => $request->Parameter_ID,
                'evalTypeID' => $request->EvalType_ID,
                'versionID' => $request->Version_ID,
                'ratingTemplateID' => $request->RatingTemplate_ID,
                'dateAdded' => now(),
                'isActive' => $request->Status,
            ]);

            ActionLogs::create([
                'type' => 'Create',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Statements',
                'affectedID' => $statement->id,
                'affectedItem' => $request->Statement,
                'description' => 'Statement created successfully',
                'status' => 1,
            ]);

            return response()->json([
                'message' => 'Statement created successfully!',
                'status' => 'success',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $statement = CourseEvalStatement::findOrFail($id);
        return response()->json($statement);
    }


    public function update(Request $request)
    {

        try {

            $statementID = $request->input('statementId');
            $statement = CourseEvalStatement::where('id', $statementID)->firstOrFail();

            $request->validate([
                'Statement' => ['required', 'string', 'max:255'],
                'SortOrder' => ['required', 'integer', 'max:100'],
                'Parameter_ID' => ['required', 'integer', 'max:500'],
                'EvalType_ID' => ['required', 'integer', 'max:500'],
                'Version_ID' => ['required', 'integer', 'max:10'],
                'RatingTemplate_ID' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $statement->statement = $request->input('Statement');
            $statement->sortOrder = $request->input('SortOrder');
            $statement->parameterID = $request->input('Parameter_ID');
            $statement->evalTypeID = $request->input('EvalType_ID');
            $statement->versionID = $request->input('Version_ID');
            $statement->ratingTemplateID = $request->input('RatingTemplate_ID');
            $statement->isActive = $request->input('Status');
            $statement->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($statement->wasChanged()) {
                $status = 1;
                $desc = 'Statement updated successfully';
            }

            ActionLogs::create([
                'type' => 'Update',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Statements',
                'affectedID' => $statement->id,
                'affectedItem' => $request->input('Statement'),
                'description' => $desc,
                'status' => $status,
            ]);

            return response()->json([
                'message' => $desc,
                'status' => 'success',
            ], 200);


        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }

    }

    public function destroy(string $id)
    {
        try {

            $statement = CourseEvalStatement::findOrFail($id);
            $statement->delete();

            ActionLogs::create([
                'type' => 'Delete',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Statements',
                'affectedID' => $statement->id,
                'affectedItem' => $statement->statement,
                'description' => 'Statement deleted successfully',
                'status' => 1,
            ]);

            return redirect()->route('courseEvalStatements.index')->with('success', 'Statement deleted successfully.');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }
    }
}
