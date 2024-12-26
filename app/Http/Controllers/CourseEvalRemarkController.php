<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalRemark;
use App\Models\CourseEvalParameter;
use Illuminate\Validation\ValidationException;
use Exception;

class CourseEvalRemarkController extends Controller
{

    public function index()
    {

        $remarks = CourseEvalRemark::
            // where('isActive', 1)
            orderBy('id', 'asc')
            ->get();

        $parameters = CourseEvalParameter::select('id', 'name', 'desc')
        ->where('isActive', 1)
        ->orderBy('id', 'asc')
        ->get();

        return view('CourseEvals.Remarks.Index', compact('remarks', 'parameters'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'Question' => ['required', 'string'],
                'PlaceHolder' => ['required', 'string', 'max:50'],
                'SortOrder_Num' => ['required', 'integer', 'max:100'],
                'SortOrder_Alpha' => ['required', 'string', 'max:1'],
                'Parameter_ID' => ['required', 'integer', 'max:100'],
                'EvalType_ID' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $remark = CourseEvalRemark::create([
                'question' => $request->Question,
                'placeHolder' => $request->PlaceHolder,
                'sortOrderN' => $request->SortOrder_Num,
                'sortOrderA' => $request->SortOrder_Alpha,
                'parameterID' => $request->Parameter_ID,
                'evalTypeID' => $request->EvalType_ID,
                'isActive' => $request->Status,
            ]);

            return response()->json([
                'message' => 'Question created successfully!',
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
        $remark = CourseEvalRemark::findOrFail($id);
        return response()->json($remark);
    }


    public function update(Request $request)
    {

        try {

            $remarkID = $request->input('remarkId');
            $remark = CourseEvalRemark::where('id', $remarkID)->firstOrFail();

            $request->validate([
                'Question' => ['required', 'string'],
                'PlaceHolder' => ['required', 'string', 'max:50'],
                'SortOrder_Num' => ['required', 'integer', 'max:100'],
                'SortOrder_Alpha' => ['required', 'string', 'max:1'],
                'Parameter_ID' => ['required', 'integer', 'max:100'],
                'EvalType_ID' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $remark->question = $request->input('Question');
            $remark->placeHolder = $request->input('PlaceHolder');
            $remark->sortOrderN = $request->input('SortOrder_Num');
            $remark->sortOrderA = $request->input('SortOrder_Alpha');
            $remark->parameterID = $request->input('Parameter_ID');
            $remark->evalTypeID = $request->input('EvalType_ID');
            $remark->isActive = $request->input('Status');
            $remark->save();

            if ($remark->wasChanged()) {
                return response()->json([
                    'message' => 'Rating updated successfully!',
                    'status' => 'success',
                ], 200);
            }else{
                return response()->json([
                    'message' => 'No changes were made!',
                    'status' => 'success',
                ], 200);
            }

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

            $user = CourseEvalRemark::findOrFail($id);
            $user->delete();
            return redirect()->route('courseEvalRemarks.index')->with('success', 'Remark deleted successfully.');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }
    }
}
