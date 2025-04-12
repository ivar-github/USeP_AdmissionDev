<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Exception;
use Throwable;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Registration::all();

        return view('Registrations.Index', compact('data'));
    }



    public function fetchData(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $columns = explode(',', $request->input('columns', ''));
            $perPage = $request->input('limit', 10);
            $gender = $request->input('gender');

            $maleCount = Registration::where('Gender', 'M')->where('TermID', 204)->count();
            $femaleCount = Registration::where('Gender', 'F')->where('TermID', 204)->count();
            $totalCount = Registration::where('TermID', 204)->count();

            $query = Registration::select($columns);
            $query->where('TermID', 204);

            if ($gender && $gender !== 'all') {
                $query->where('Gender', $gender);
            }

            $data = $query->paginate($perPage);

            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'counts' => [
                    'male' => $maleCount,
                    'female' => $femaleCount,
                    'total' => $totalCount,
                ]
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
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
