<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Program;
use App\Models\Major;
use App\Models\ScheduleCenter;
use App\Models\ScheduleDate;
use App\Models\ScheduleView;
use App\Models\ScheduleViewSlot;
use Illuminate\Support\Facades\DB;

use App\Exports\ExportApplicantsSchedule;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->where('IsForAdmission', 1)
                ->limit(100)
                ->orderBy('TermID', 'desc')->get();

            $campuses = collect([
                    (object) ['id' => 1, 'name' => 'Obrero'],
                    (object) ['id' => 6, 'name' => 'Mintal'],
                    (object) ['id' => 7, 'name' => 'Tagum'],
                    (object) ['id' => 8, 'name' => 'Mabini'],
                    (object) ['id' => 10, 'name' => 'Malabog'],
                ]);

            return view('Schedules.Analytics', compact('terms', 'campuses'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function scheduleApplicants()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->where('IsForAdmission', 1)
                ->limit(1)
                ->orderBy('TermID', 'desc')->get();

            $centers = ScheduleCenter::select('id', 'campusID', 'testCenterName')
                ->orderBy('campusID', 'asc')->get();

            return view('Schedules.Applicants', compact('terms', 'centers' ));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getDates(Request $request)
    {
        try {

            $centerId = $request->input('centerID');
            $termId = $request->input('termID');

            $dates = ScheduleViewSlot::select('testDateID', 'testDate')
                ->distinct()
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->where('termID', $termId)
                ->orderBy('testDate', 'asc')
                ->get();

            return response()->json($dates);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function getData(Request $request)
    {

        try {

            $columns = explode(',', $request->input('columns', ''));
            $perPage = $request->input('limit', 10);
            $termId = $request->input('termID');
            $centerId = $request->input('centerID');
            $dateFromId = $request->input('dateFromID');
            $dateToId = $request->input('dateToID');
            $search = $request->input('search');

            $prefRowQuery = ScheduleView::select($columns)
                ->where('TermID', $termId)
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->when($dateFromId && $dateToId, fn($query) => $query->whereBetween('testDate', [$dateFromId, $dateToId]))
                ->when($dateFromId && !$dateToId, fn($query) => $query->where('testDate', '>=', $dateFromId))
                ->when(!$dateFromId && $dateToId, fn($query) => $query->where('testDate', '<=', $dateToId))
                ->orderBy('Name', 'asc') ;


            if ($search) {
                $prefRowQuery->where(function($q) use ($search) {
                    $q->where('Name', 'LIKE', '%' . $search . '%')
                    ->orWhere('appNo', 'LIKE', '%' . $search . '%');
                });
            }

            $data = $prefRowQuery->paginate($perPage);

            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total()
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function exportApplicantsScheds(Request $request)
    {
        try {

            $columns = explode(',', $request->input('columns', ''));
            $filters = $request->only(['termID', 'centerID', 'dateFromID', 'dateToID', 'search']);

            $termID = $filters['termID'] ?? 'N/A';
            $centerID = $filters['centerID'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';

            ActionLogs::create([
                'type' => 'Read',
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'module' => 'USePAT Schedule - Applicant',
                'affectedItem' => 'Applicants List',
                'description' => "Term: $termID, Center: $centerID, Searched: $search, Schedule List Exported",
                'status' => 1,
            ]);


            return Excel::download(new ExportApplicantsSchedule($columns, $filters), 'applicantsSchedules-data.xlsx');

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
