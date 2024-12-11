<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $datas = Employee::all();

        return view('Datas.Index', compact('datas'));
    }



    public function fetchData(Request $request)
{
    $columns = explode(',', $request->input('columns', ''));
    $perPage = $request->input('limit', 10);
    $gender = $request->input('gender');

    // Get gender counts
    $maleCount = Employee::where('Gender', 'M')->count();
    $femaleCount = Employee::where('Gender', 'F')->count();
    $totalCount = Employee::count();

    $query = Employee::select($columns);

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
