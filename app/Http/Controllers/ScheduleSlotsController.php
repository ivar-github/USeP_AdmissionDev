<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Program;
use App\Models\Major;
use App\Models\ScheduleCenter;
use App\Models\ScheduleDate;
use App\Models\ScheduleTime;
use App\Models\ScheduleRoom;
use App\Models\ScheduleSession;

use App\Models\ScheduleView;
use App\Models\ScheduleViewSlot;
use App\Models\ScheduleSlot;
use Illuminate\Support\Facades\DB;

use App\Exports\ExportApplicantsSchedule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleSlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->where('IsForAdmission', 1)
                ->limit(1)
                ->orderBy('TermID', 'desc')->get();

            $centers = ScheduleCenter::select('id', 'campusID', 'testCenterName')
                ->where('isActive', 1)
                ->orderBy('campusID', 'asc')->get();

            return view('Schedules.ScheduleSlots', compact('terms', 'centers' ));

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
            $roomId = $request->input('roomID');
            $search = $request->input('search');
            $sort = $request->input('sort');

            $inActive = $request->boolean('inActive', false);
            $isVacant = $request->boolean('isVacant', false) ? 'False' : 'True';

            $prefRowQuery = ScheduleViewSlot::select($columns)
                ->where('TermID', $termId)
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->when($roomId != 0, fn($query) => $query->where('testRoomID', $roomId))
                ->when($dateFromId && $dateToId, fn($query) => $query->whereBetween('testDate', [$dateFromId, $dateToId]))
                ->when($dateFromId && !$dateToId, fn($query) => $query->where('testDate', '>=', $dateFromId))
                ->when(!$dateFromId && $dateToId, fn($query) => $query->where('testDate', '<=', $dateToId))
                ->where('isActive', !$inActive)
                ->where('isFull', '=', $isVacant)
                ->orderBy('testDate', 'asc') 
                ->orderBy($sort, 'asc') ;


            if ($search) {
                $prefRowQuery->where(function($q) use ($search) {
                    $q->where('testDate', 'LIKE', '%' . $search . '%')
                    ->orWhere('testTimeStartString', 'LIKE', '%' . $search . '%')
                    ->orWhere('testSessionName', 'LIKE', '%' . $search . '%')
                    ->orWhere('testRoomName', 'LIKE', '%' . $search . '%');
                });
            }

            $data = $prefRowQuery->paginate($perPage);

            // $agent = new Agent();
            // $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            // ActionLogs::create([
            //     'type' => 'Read',
            //     'module' => 'USePAT Schedule - Applicant',
            //     'affectedItem' => 'Generate Applicants List',
            //     'description' => "Term: $termId, Center: $centerId, Searched: $search, DateFrom: $dateFromId, DateTo: $dateToId, Schedules List Generated",
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
            $dateFromID = $filters['dateFromID'] ?? 'N/A';
            $dateToID = $filters['dateToID'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';


            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Schedule - Applicant',
                'affectedItem' => 'Export Applicants List',
                'description' => "Term: $termID, Center: $centerID, Searched: $search, DateFrom: $dateFromID, DateTo: $dateToID, Schedules List Exported",
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
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
    public function edit(string $id): JsonResponse
    {
        try {
            $slot = ScheduleSlot::select(
                    'id',
                    'testCenterID',
                    'testDateID',
                    'testTimeID',
                    'testSessionID',
                    'testRoomID',
                    'termID',
                )
                ->where('id', $id)
                ->first(); 

            if (!$slot) {
                return response()->json([
                    'message' => 'Applicant not found!',
                    'status' => 'error',
                ], 404);
            }

            return response()->json($slot);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
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
