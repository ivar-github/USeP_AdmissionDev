<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Term;
use App\Models\Program;
use App\Models\Major;
use Illuminate\Support\Facades\DB;

use App\Exports\ResultsExport;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            ->limit(100)
            ->orderBy('TermID', 'desc')->get();

        $campuses = collect([
                (object) ['id' => 1, 'name' => 'Obrero'],
                (object) ['id' => 6, 'name' => 'Mintal'],
                (object) ['id' => 7, 'name' => 'Tagum'],
                (object) ['id' => 8, 'name' => 'Mabini'],
                (object) ['id' => 10, 'name' => 'Malabog'],
            ]);

        return view('Results.Analytics', compact('terms', 'campuses'));
    }

    public function data()
    {

        $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            ->limit(100)
            ->orderBy('TermID', 'desc')->get();

        $campuses = collect([
                (object) ['id' => 1, 'name' => 'Obrero'],
                (object) ['id' => 6, 'name' => 'Mintal'],
                (object) ['id' => 7, 'name' => 'Tagum'],
                (object) ['id' => 8, 'name' => 'Mabini'],
                (object) ['id' => 10, 'name' => 'Malabog'],
            ]);
        // dd($terms);

        return view('Results.Table', compact('terms', 'campuses'));
    }


    public function getPrograms(Request $request)
    {
        $campusId = $request->input('campusId');
        $programs = Program:: when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
            ->where('Display_Online', 1)
            ->orderBy('ProgName', 'asc')->get();
        return response()->json($programs);
    }

    public function getMajors(Request $request)
    {
        $campusId = $request->input('campusId');
        $programId = $request->input('programId');

        $majors = Major:: when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
            ->when($programId != 0, fn($query) => $query->where('ProgID', $programId))
            ->where('Display_Online', 1)
            ->where('MajorID', '!=', 0)
            ->where('MajorID', '!=', '')
            ->orderBy('Major', 'asc')->get();
        return response()->json($majors);
    }

    public function getData(Request $request)
    {

        $columns = explode(',', $request->input('columns', ''));
        $perPage = $request->input('limit', 10);
        $status = $request->input('status');
        $termID = $request->input('termID');
        $campus = $request->input('campus');
        $program = $request->input('program');
        $major = $request->input('major');
        $search = $request->input('search');


        $prefCountQuery = Result::where('TermID', $termID)
            ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
            ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
            ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major));

        if ($search) {
            $prefCountQuery->where(function($q) use ($search) {
                $q->where('Applicant', 'LIKE', '%' . $search . '%')
                ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
            });
        }

        $qualifiedCount = (clone $prefCountQuery)->where('Status', 'Qualified')->count();
        $waivedslotCount = (clone $prefCountQuery)->where('Status', 'WaivedSlot')->count();
        $confirmedtCount = (clone $prefCountQuery)->where('isEnlisted', '1')->count();
        $totalCount = $prefCountQuery->count();


        $prefRowQuery = Result::select($columns)
            ->where('TermID', $termID)
            ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
            ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
            ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major))
            ->when($status && $status !== 'all' && $status !== '1', fn($query) => $query->where('Status', $status))
            ->when($status == 1, fn($query) => $query->where('isEnlisted', $status));

        if ($search) {
            $prefRowQuery->where(function($q) use ($search) {
                $q->where('Applicant', 'LIKE', '%' . $search . '%')
                ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $prefRowQuery->paginate($perPage);


        $results = Result::select(
            'TermID',
            DB::raw("SUM(CASE WHEN Status = 'Qualified' THEN 1 ELSE 0 END) as AppQualified"),
            DB::raw("SUM(CASE WHEN Status = 'WaivedSlot' THEN 1 ELSE 0 END) as AppWaivedSlot"),
            DB::raw("SUM(CASE WHEN IsEnlisted = '1' THEN 1 ELSE 0 END) as AppConfirmed"),
            DB::raw("SUM(CASE WHEN AppNo != '' THEN 1 ELSE 0 END) as AppTotal")
        )
        ->groupBy('TermID')
        ->orderBy('TermID', 'desc')
        ->take(10)
        ->get();

        $dataGraph = [];
        foreach ($results as $item) {
            $dataGraph[] = [
                'TermID' => $item->AcademicYear,
                // 'TermID' => $item->AcademicYear . '-' . substr($item->SchoolTerm, 0, 3),
                'appQualified' => $item->AppQualified,
                'appConfirmed' => $item->AppConfirmed,
                'appWaivedSlot' => $item->AppWaivedSlot,
                'appTotal' => $item->AppTotal,
            ];
        }

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
            'counts' => [
                'qualified' => $qualifiedCount,
                'waivedslot' => $waivedslotCount,
                'confirmed' => $confirmedtCount,
                'total' => $totalCount,
            ],
            'graph' => $dataGraph
        ]);
    }

    public function exportResults(Request $request)
    {
        $columns = explode(',', $request->input('columns', ''));
        $filters = $request->only(['termID', 'campus', 'program', 'major', 'status', 'search']);

        return Excel::download(new ResultsExport($columns, $filters), 'results-data.xlsx');
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
