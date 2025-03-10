<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Term;
use App\Models\Program;
use App\Models\Major;
use Illuminate\Support\Facades\DB;

use App\Exports\ExportApplicantsResult;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('Results.Dashboard');
    }

    public function applicants()
    {

        try {
           
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

            return view('Results.Applicants', compact('terms', 'campuses'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getPrograms(Request $request)
    {
        try {

            $campusId = $request->input('campusId');
            $programs = Program:: when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
                ->where('Display_Online', 1)
                ->orderBy('ProgName', 'asc')->get();
            return response()->json($programs);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getMajors(Request $request)
    {
        try {

            $campusId = $request->input('campusId');
            $programId = $request->input('programId');

            $majors = Major:: when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
                ->when($programId != 0, fn($query) => $query->where('ProgID', $programId))
                ->where('Display_Online', 1)
                ->where('MajorID', '!=', 0)
                ->where('MajorID', '!=', '')
                ->orderBy('Major', 'asc')->get();

            return response()->json($majors);

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

            $results = DB::connection('sqlsrv2')
                ->table('CUSTOM_AdmissionQualifiedApplicantsOfficial as results')
                ->select(
                    'results.TermID',
                    'terms.AcademicYear',
                    'terms.SchoolTerm',
                    DB::raw("SUM(CASE WHEN results.Status = 'Qualified' THEN 1 ELSE 0 END) as AppQualified"),
                    DB::raw("SUM(CASE WHEN results.Status = 'WaivedSlot' THEN 1 ELSE 0 END) as AppWaivedSlot"),
                    DB::raw("SUM(CASE WHEN results.IsEnlisted = '1' THEN 1 ELSE 0 END) as AppConfirmed"),
                    DB::raw("SUM(CASE WHEN results.AppNo != '' THEN 1 ELSE 0 END) as AppTotal")
                )
                ->join('ES_AYTerm as terms', 'terms.TermID', '=', 'results.TermID')
                ->groupBy('results.TermID', 'terms.AcademicYear', 'terms.SchoolTerm')
                ->orderBy('results.TermID', 'desc')
                ->take(10)
                ->get();

            $dataGraph = [];
            foreach ($results as $item) {
                $dataGraph[] = [
                    'TermID' => $item->TermID,
                    'AYear' => $item->AcademicYear,
                    'STerm' => substr($item->SchoolTerm, 0, 3),
                    'appQualified' => $item->AppQualified,
                    'appConfirmed' => $item->AppConfirmed,
                    'appWaivedSlot' => $item->AppWaivedSlot,
                    'appTotal' => $item->AppTotal,
                ];
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Result',
                'affectedItem' => 'Generate Applicants List',
                'description' => "Term: $termID, Campus: $campus, Program: $program, Major: $major, Status: $status, Searched: $search Result List Generated",
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

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

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function exportApplicantsResults(Request $request)
    {
        try {

            $columns = explode(',', $request->input('columns', ''));
            $filters = $request->only(['termID', 'campus', 'program', 'major', 'status', 'search']);

            $termID = $filters['termID'] ?? 'N/A';
            $campus = $filters['campus'] ?? 'N/A';
            $program = $filters['program'] ?? 'N/A';
            $major = $filters['major'] ?? 'N/A';
            $status = $filters['status'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';


            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Result',
                'affectedItem' => 'Export Applicants List',
                'description' => "Term: $termID, Campus: $campus, Program: $program, Major: $major, Status: $status, Searched: $search, Result List Exported",
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return Excel::download(new ExportApplicantsResult($columns, $filters), 'applicantsResults-data.xlsx');

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //      
    }

    
    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
