<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalParameter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;

class CourseEvalParameterController extends Controller
{

    public function index()
    {

        $parameters = CourseEvalParameter::
            // where('isActive', 1)
            orderBy('id', 'asc')
            ->get();

        return view('CourseEvals.Parameters.Index', compact('parameters'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'Name' => ['required', 'string', 'max:255'],
                'Description' => ['required', 'string', 'max:255'],
                'SortOrder_Num' => ['required', 'integer', 'max:100'],
                'SortOrder_Alpha' => ['required', 'string', 'max:1'],
                'Status' => ['required', 'integer', 'in:0,1'],
                'EvalType_ID' => ['required', 'integer'],
            ]);

            $parameter = CourseEvalParameter::create([
                'name' => $request->Name,
                'desc' => $request->Description,
                'sortOrderN' => $request->SortOrder_Num,
                'sortOrderA' => $request->SortOrder_Alpha,
                'isActive' => $request->Status,
                'dateAdded' => now(),
                'evalTypeID' => $request->EvalType_ID,
            ]);

            ActionLogs::create([
                'type' => 'Create',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Parameters',
                'affectedID' => $parameter->id,
                'affectedItem' => $request->Name,
                'description' => 'Parameter created successfully',
                'status' => 1,
            ]);

            return response()->json([
                'message' => 'Parameter created successfully!',
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
        $parameter = CourseEvalParameter::findOrFail($id);
        return response()->json($parameter);
    }


    public function update(Request $request)
    {

        try {

            $parameterID = $request->input('parameterId');
            $parameter = CourseEvalParameter::where('id', $parameterID)->firstOrFail();

            $request->validate([
                'Name' => ['required', 'string', 'max:255'],
                'Description' => ['required', 'string', 'max:255'],
                'SortOrder_Num' => ['required', 'integer', 'max:100'],
                'SortOrder_Alpha' => ['required', 'string', 'max:1'],
                'Status' => ['required', 'integer', 'in:0,1'],
                'EvalType_ID' => ['required', 'integer'],
            ]);

            $parameter->name = $request->input('Name');
            $parameter->desc = $request->input('Description');
            $parameter->sortOrderN = $request->input('SortOrder_Num');
            $parameter->sortOrderA = $request->input('SortOrder_Alpha');
            $parameter->isActive = $request->input('Status');
            $parameter->evalTypeID = $request->input('EvalType_ID');
            $parameter->save();


            $status = 0;
            $desc = '';
            if ($parameter->wasChanged()) {
                $status = 1;
                $desc = 'Parameter updated successfully';
            } else {
                $desc = 'No changes were made';
            }

            ActionLogs::create([
                'type' => 'Update',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Parameters',
                'affectedID' => $parameter->id,
                'affectedItem' => $request->input('Name'),
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

            $parameter = CourseEvalParameter::findOrFail($id);
            $parameter->delete();

            ActionLogs::create([
                'type' => 'Delete',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Parameters',
                'affectedID' => $parameter->id,
                'affectedItem' => $parameter->name,
                'description' => 'Parameter deleted successfully',
                'status' => 1,
            ]);

            return redirect()->route('courseEvalParameters.index')->with('success', 'Parameter deleted successfully.');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }
    }
}
