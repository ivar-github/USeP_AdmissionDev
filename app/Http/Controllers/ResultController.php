<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\ResultView;
use App\Models\ResultRankingView;
use App\Models\Term;
use App\Models\Program;
use App\Models\ProgramMajorsView;
use App\Models\ResultOverallView;
use App\Models\CollegeProgramMajorStatic;
use App\Models\Major;
use Illuminate\Support\Facades\DB;

use App\Exports\ExportApplicantsResultOverall;
use App\Exports\ExportApplicantsResultTransferees;
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

    public function index()
    {
        return view('Results.Dashboard');
    }


    public function applicants()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->limit(100)
                ->orderBy('TermID', 'desc')
                ->get();

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


    public function overall()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->limit(100)
                ->orderBy('TermID', 'desc')
                ->get();

            $campuses = collect([
                (object) ['id' => 1, 'name' => 'Obrero'],
                (object) ['id' => 6, 'name' => 'Mintal'],
                (object) ['id' => 7, 'name' => 'Tagum'],
                (object) ['id' => 8, 'name' => 'Mabini'],
                (object) ['id' => 10, 'name' => 'Malabog'],
            ]);

            return view('Results.Overall', compact('terms', 'campuses'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function transferees()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->limit(100)
                ->orderBy('TermID', 'desc')
                ->get();

            $campuses = collect([
                (object) ['id' => 1, 'name' => 'Obrero'],
                (object) ['id' => 6, 'name' => 'Mintal'],
                (object) ['id' => 7, 'name' => 'Tagum'],
                (object) ['id' => 8, 'name' => 'Mabini'],
                (object) ['id' => 10, 'name' => 'Malabog'],
            ]);

            return view('Results.Transferees', compact('terms', 'campuses'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getColleges(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $campusId = $request->input('campusId');

            $programs = CollegeProgramMajorStatic::select('CollegeID', 'CollegeName', 'ProgClass', 'CampusID')
                ->distinct()
                ->when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
                ->where('Display_Online', 1)
                ->where('ProgClass', 50)
                ->orderBy('CollegeName', 'asc')
                ->get();

            return response()->json($programs);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getPrograms(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $campusId = $request->input('campusId');
            $collegeId = $request->input('collegeId');
            $programs = CollegeProgramMajorStatic::select('ProgID', 'ProgName', 'ProgCode')
                ->distinct()
                ->when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
                ->when($collegeId != 0, fn($query) => $query->where('CollegeID', $collegeId))
                ->where('Display_Online', 1)
                ->orderBy('ProgName', 'asc')
                ->get();

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

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $campusId = $request->input('campusId');
            $programId = $request->input('programId');
            $collegeId = $request->input('collegeId');

            $majors = CollegeProgramMajorStatic::select('ProgID', 'ProgName', 'MajorID', 'Major')
                ->when($campusId != 0, fn($query) => $query->where('CampusID', $campusId))
                ->when($collegeId != 0, fn($query) => $query->where('CollegeID', $collegeId))
                ->when($programId != 0, fn($query) => $query->where('ProgID', $programId))
                ->where('Display_Online', 1)
                ->where('MajorID', '!=', 0)
                ->where('MajorID', '!=', '')
                ->where('ProgClass', '=', 50)
                ->orderBy('Major', 'asc')
                ->get();

            return response()->json($majors);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDashboard(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $results = DB::connection('sqlsrv2')
                ->table('vw_QualifiedApplicantsOfficialDetails as results')
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
            return response()->json([
                'graph' => $dataGraph
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getData(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $columns = explode(',', $request->input('columns', ''));
            $perPage = $request->input('limit', 10);
            $status = $request->input('status');
            $termID = $request->input('termID');
            $campus = $request->input('campus');
            $college = $request->input('college');
            $program = $request->input('program');
            $major = $request->input('major');
            $search = $request->input('search');
            $sort = $request->input('sort');
            $isAscending = $request->boolean('isAscending') ? 'asc' : 'desc';


            $prefCountQuery = ResultView::where('TermID', $termID)
                // ->distinct()
                ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
                ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
                ->when($college != 0, fn($query) => $query->where('CollegeID', $college))
                ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major));

            if ($search) {
                $prefCountQuery->where(function($q) use ($search) {
                    $q->where('Applicant', 'LIKE', '%' . $search . '%')
                    ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
                });
            }

            $qualifiedCount = (clone $prefCountQuery)->where('Status', 'Qualified')->count();
            $waivedslotCount = (clone $prefCountQuery)->where('Status', 'WaivedSlot')->count();
            $waitlistedCount = (clone $prefCountQuery)->where('Status', 'Waitlisted')->count();
            $confirmedtCount = (clone $prefCountQuery)->where('isEnlisted', '1')->count();
            $totalCount = $prefCountQuery->count();

            $prefRowQuery = ResultView::select($columns)
                ->distinct()
                ->where('TermID', $termID)
                ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
                ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
                ->when($college != 0, fn($query) => $query->where('CollegeID', $college))
                ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major))
                ->when($status && $status !== 'all' && $status !== '1', fn($query) => $query->where('Status', $status))
                ->when($status == 1, fn($query) => $query->where('isEnlisted', $status))
                ->when($sort, fn($query) => $query->orderBy($sort, $isAscending));

            if ($search) {
                $prefRowQuery->where(function($q) use ($search) {
                    $q->where('Applicant', 'LIKE', '%' . $search . '%')
                    ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
                });
            }

            $academicCount = (clone $prefRowQuery)->where('Track_ID', 1)->count();
            $techVocCount = (clone $prefRowQuery)->where('Track_ID', 2)->count();
            $sportsCount = (clone $prefRowQuery)->where('Track_ID', 3)->count();
            $artsDesignCount = (clone $prefRowQuery)->where('Track_ID', 4)->count();

            $choiceACount = (clone $prefRowQuery)->where('coursePreferenceLvl', 1)->count();
            $choiceBCount = (clone $prefRowQuery)->where('coursePreferenceLvl', 2)->count();
            $choiceCCount = (clone $prefRowQuery)->where('coursePreferenceLvl', 3)->count();

            $data = $prefRowQuery->paginate($perPage);

            // $agent = new Agent();
            // $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            // ActionLogs::create([
            //     'type' => 'Read',
            //     'module' => 'USePAT Result',
            //     'affectedItem' => 'Generate Applicants List',
            //     'description' => "Term: $termID, Campus: $campus, Program: $program, Major: $major, Status: $status, Searched: $search Result List Generated",
            //     'status' => 1,
            //     'userID' => Auth::user()->id,
            //     'userEmail' => Auth::user()->email,
            //     'hostName' => gethostname(),
            //     'platform' => $agentInfo,
            // ]);

            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'counts' => [
                    'qualified' => $qualifiedCount,
                    'waivedslot' => $waivedslotCount,
                    'waitlisted' => $waitlistedCount,
                    'confirmed' => $confirmedtCount,
                    'total' => $totalCount,

                    'academic' => $academicCount,
                    'techVoc' => $techVocCount,
                    'sports' => $sportsCount,
                    'artsDesign' => $artsDesignCount,

                    'choiceA' => $choiceACount,
                    'choiceB' => $choiceBCount,
                    'choiceC' => $choiceCCount,
                ],
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOverallData(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            ini_set('max_execution_time', 300);

            $columns = explode(',', $request->input('columns', ''));
            $perPage = $request->input('limit', 10);
            $status = $request->input('status');
            $termID = $request->input('termID');
            $campus = $request->input('campus');
            $college = $request->input('college');
            $program = $request->input('program');
            $major = $request->input('major');
            $search = $request->input('search');
            $sort = $request->input('sort');
            $isAscending = $request->boolean('isAscending') ? 'asc' : 'desc';


            $prefCountQuery = ResultOverallView::select($columns)
                ->where('TermID', $termID)
                ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
                ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
                ->when($college != 0, fn($query) => $query->where('CollegeID', $college))
                ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major))
                ->when($search, fn($query) =>
                    $query->where(function ($query) use ($search) {
                        $query->where('ApplicantName', 'LIKE', "%$search%")
                        ->orWhere('AppNo', 'LIKE', "%$search%");
                    })
                );
                // ->groupBy($columns);

            $qualifiedCount = (clone $prefCountQuery)->where('Status', 'Qualified')->count();
            $waivedslotCount = (clone $prefCountQuery)->where('Status', 'WaivedSlot')->count();
            $waitlistedCount = (clone $prefCountQuery)->where('Status', 'Waitlisted')->count();
            $notQualifiedCount = (clone $prefCountQuery)->where('Status', 'NotQualified')->count();
            $confirmedtCount = (clone $prefCountQuery)->where('isEnlisted', '1')->count();
            $totalCount = $prefCountQuery->count();

            $prefRowQuery = ResultOverallView::select($columns)
                ->where('TermID', $termID)
                ->when($campus != 0, fn($query) => $query->where('CampusID', $campus))
                ->when($program != 0, fn($query) => $query->where('QualifiedCourseID', $program))
                ->when($college != 0, fn($query) => $query->where('CollegeID', $college))
                ->when($major != 0, fn($query) => $query->where('QualifiedMajorID', $major))
                ->when($status && $status !== 'all' && $status !== '1', fn($query) => $query->where('Status', $status))
                ->when($status == 1, fn($query) => $query->where('isEnlisted', $status))
                ->when($search, fn($query) =>
                    $query->where(function ($q) use ($search) {
                        $q->where('ApplicantName', 'LIKE', '%' . $search . '%')
                        ->orWhere('AppNo', 'LIKE', '%' . $search . '%');
                    })
                )
                ->when($sort, fn($q) => $q->orderBy($sort, $isAscending));
                // ->groupBy($columns);

            $academicCount = (clone $prefRowQuery)->where('Track_ID', 1)->count();
            $techVocCount = (clone $prefRowQuery)->where('Track_ID', 2)->count();
            $sportsCount = (clone $prefRowQuery)->where('Track_ID', 3)->count();
            $artsDesignCount = (clone $prefRowQuery)->where('Track_ID', 4)->count();

            $choiceACount = (clone $prefRowQuery)->where('coursePreferenceLvl', 1)->count();
            $choiceBCount = (clone $prefRowQuery)->where('coursePreferenceLvl', 2)->count();
            $choiceCCount = (clone $prefRowQuery)->where('coursePreferenceLvl', 3)->count();

            $data = $prefRowQuery->paginate($perPage);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Result',
                'affectedItem' => 'Generate Overall Applicants List',
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
                    'waitlisted' => $waitlistedCount,
                    'confirmed' => $confirmedtCount,
                    'notQualified' => $notQualifiedCount,
                    'total' => $totalCount,

                    'academic' => $academicCount,
                    'techVoc' => $techVocCount,
                    'sports' => $sportsCount,
                    'artsDesign' => $artsDesignCount,

                    'choiceA' => $choiceACount,
                    'choiceB' => $choiceBCount,
                    'choiceC' => $choiceCCount,
                ],
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getTransfereeData(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $columns = explode(',', $request->input('columns', ''));
            $perPage = $request->input('limit', 10);
            $termID = $request->input('termID');
            $campus = $request->input('campus');
            $search = $request->input('search');
            $sort = $request->input('sort');
            $isAscending = $request->boolean('isAscending') ? 'asc' : 'desc';

            $query = ResultRankingView::select($columns)
                ->where('TermID', $termID)
                ->where('ApplyTypeID', 2)
                ->when($campus != 0, fn($q) => $q->where('CampusID', $campus))
                ->when($search, fn($q) =>
                    $q->where(function ($q) use ($search) {
                        $q->where('ApplicantName', 'LIKE', "%$search%")
                        ->orWhere('AppNo', 'LIKE', "%$search%");
                    })
                )
                ->when($sort, fn($q) => $q->orderBy($sort, $isAscending))
                ->groupBy($columns);

            $data = $query->paginate($perPage);

            // $agent = new Agent();
            // $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            // ActionLogs::create([
            //     'type' => 'Read',
            //     'module' => 'USePAT Result',
            //     'affectedItem' => 'Generate Applicants List',
            //     'description' => "Term: $termID, Campus: $campus, Program: $program, Major: $major, Status: $status, Searched: $search Result List Generated",
            //     'status' => 1,
            //     'userID' => Auth::user()->id,
            //     'userEmail' => Auth::user()->email,
            //     'hostName' => gethostname(),
            //     'platform' => $agentInfo,
            // ]);

            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
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

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $columns = explode(',', $request->input('columns', ''));
            $filters = $request->only(['termID', 'campus', 'program', 'major', 'status', 'search', 'sort', 'isAscending', 'export']);

            $termID = $filters['termID'] ?? 'N/A';
            $campus = $filters['campus'] ?? 'N/A';
            $program = $filters['program'] ?? 'N/A';
            $major = $filters['major'] ?? 'N/A';
            $status = $filters['status'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';
            $sort = $filters['sort'] ?? 'N/A';
            $isAscending = $filters['isAscending'] ?? 'N/A';
            $export = $filters['export'];


            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Result',
                'affectedItem' => "Export $export Applicants List",
                'description' => "Term: $termID, Campus: $campus, Program: $program, Major: $major, Status: $status, Searched: $search, Result List Exported",
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);
            if ($export == 'Overall') {
                return Excel::download(new ExportApplicantsResultOverall($columns, $filters), 'applicantsResultsOverall-data.xlsx');

            } else if ($export == 'Qualified') {
                return Excel::download(new ExportApplicantsResult($columns, $filters), 'applicantsResultsQualified-data.xlsx');

            } else if ($export == 'Transferees') {
                return Excel::download(new ExportApplicantsResultTransferees($columns, $filters), 'applicantsResultsTransferees-data.xlsx');

            } else {
                return response()->json([
                    'error' => 'An unexpected error occurred',
                    'message' => 'Invalid Export',
                ], 500);
            }

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
