<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEvalParameter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string', 'max:255'],
            'sortorderN' => ['required', 'integer', 'max:100'],
            'sortorderA' => ['required', 'string', 'max:2'],
            'status' => ['required', 'integer', 'in:0,1'],
            'evaltypeID' => ['required', 'integer'],
        ]);

        $parameter = CourseEvalParameter::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'sortOrderN' => $request->sortorderN,
            'sortOrderA' => $request->sortorderA,
            'isActive' => $request->status,
            'dateAdded' => now(),
            'evalTypeID' => $request->evaltypeID,
        ]);

        session()->flash('success', $request->name . ' has been created successfully!');
        return response()->json(['message' => $request->name . ' has been created successfully!'], 200);
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
        $parameterID = $request->input('parameterId');
        $parameter = CourseEvalParameter::where('id', $parameterID)->firstOrFail();
        $request->validate([
            'a' => ['required', 'string', 'max:255'],
            'b' => ['required', 'string', 'max:255'],
            'c' => ['required', 'integer', 'max:100'],
            'd' => ['required', 'string', 'max:2'],
            'e' => ['required', 'integer', 'in:0,1'],
            'f' => ['required', 'integer'],
        ]);
    
    
        $parameter->name = $request->input('a');
        $parameter->desc = $request->input('b');
        $parameter->sortOrderN = $request->input('c');
        $parameter->sortOrderA = $request->input('d');
        $parameter->isActive = $request->input('e');
        $parameter->evalTypeID = $request->input('f');
        $parameter->save();



        if ($parameter->wasChanged()) {
            session()->flash('success', $request->a . ' has been updated successfully!');
            return response()->json(['message' => $request->a . ' has been updated successfully!'], 200);
        }
    
        return response()->json(['message' => 'No changes were made.'], 400);
    }


    public function destroy(string $id)
    {
        
        $user = CourseEvalParameter::findOrFail($id);
        dd($user);
        $user->delete();

        return redirect()->route('courseEvalParameters.index')->with('success', 'Parameter deleted successfully.');
    }
}
