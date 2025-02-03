<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalRating;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;

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

        try {
            $request->validate([
                'Description' => ['required', 'string', 'max:50'],
                'Alias' => ['required', 'string', 'max:5'],
                'Rating' => ['required', 'string', 'max:3'],
                'SortOrder' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
                'EvalTemp_ID' => ['required', 'integer'],
            ]);

            $rating = CourseEvalRating::create([
                'description' => $request->Description,
                'alias' => $request->Alias,
                'rating' => $request->Rating,
                'sortOrder' => $request->SortOrder,
                'isActive' => $request->Status,
                'evalTemplateID' => $request->EvalTemp_ID,
            ]);

            ActionLogs::create([
                'type' => 'Create',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Ratings',
                'affectedID' => $rating->id,
                'affectedItem' => $request->Description,
                'description' => 'Rating created successfully',
                'status' => 1,
            ]);

            return response()->json([
                'message' => 'Rating created successfully!',
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
        $rating = CourseEvalRating::findOrFail($id);
        return response()->json($rating);
    }


    public function update(Request $request)
    {

        try {

            $ratingID = $request->input('ratingId');
            $rating = CourseEvalRating::where('id', $ratingID)->firstOrFail();

            $request->validate([
                'Description' => ['required', 'string', 'max:50'],
                'Alias' => ['required', 'string', 'max:5'],
                'Rating' => ['required', 'string', 'max:3'],
                'SortOrder' => ['required', 'integer', 'max:100'],
                'Status' => ['required', 'integer', 'in:0,1'],
                'EvalTemp_ID' => ['required', 'integer'],
            ]);

            $rating->description = $request->input('Description');
            $rating->alias = $request->input('Alias');
            $rating->rating = $request->input('Rating');
            $rating->sortOrder = $request->input('SortOrder');
            $rating->isActive = $request->input('Status');
            $rating->evalTemplateID = $request->input('EvalTemp_ID');
            $rating->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($rating->wasChanged()) {
                $status = 1;
                $desc = 'Rating updated successfully';
            }

            ActionLogs::create([
                'type' => 'Update',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Ratings',
                'affectedID' => $rating->id,
                'affectedItem' => $request->input('Description'),
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

            $rating = CourseEvalRating::findOrFail($id);
            $rating->delete();

            ActionLogs::create([
                'type' => 'Delete',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'CourseEval Ratings',
                'affectedID' => $rating->id,
                'affectedItem' => $rating->description,
                'description' => 'Rating deleted successfully',
                'status' => 1,
            ]);

            return redirect()->route('courseEvalRatings.index')->with('success', 'Rating deleted successfully.');

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }
    }
}
