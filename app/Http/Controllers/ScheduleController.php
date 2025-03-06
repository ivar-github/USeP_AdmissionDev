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
use Illuminate\Support\Facades\DB;

use App\Exports\ExportApplicantsSchedule;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

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


    public function getRooms(Request $request)
    {
        try {

            $centerId = $request->input('centerID');
            $termId = $request->input('termID');
            $dateFromId = $request->input('dateFromID');
            $dateToId = $request->input('dateToID');

            $rooms = ScheduleViewSlot::select('testRoomID', 'testRoomName')
                ->distinct()
                ->where('termID', $termId)
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->when($dateFromId && $dateToId, fn($query) => $query->whereBetween('testDate', [$dateFromId, $dateToId]))
                ->when($dateFromId && !$dateToId, fn($query) => $query->where('testDate', '>=', $dateFromId))
                ->when(!$dateFromId && $dateToId, fn($query) => $query->where('testDate', '<=', $dateToId))
                ->orderBy('testRoomName', 'asc')
                ->get();

            return response()->json($rooms);

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

            $prefRowQuery = ScheduleView::select($columns)
                ->where('TermID', $termId)
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->when($roomId != 0, fn($query) => $query->where('testRoomID', $roomId))
                ->when($dateFromId && $dateToId, fn($query) => $query->whereBetween('testDate', [$dateFromId, $dateToId]))
                ->when($dateFromId && !$dateToId, fn($query) => $query->where('testDate', '>=', $dateFromId))
                ->when(!$dateFromId && $dateToId, fn($query) => $query->where('testDate', '<=', $dateToId))
                ->when($sort, fn($query) => $query->orderBy($sort, 'asc'));


            if ($search) {
                $prefRowQuery->where(function($q) use ($search) {
                    $q->where('Name', 'LIKE', '%' . $search . '%')
                    ->orWhere('appNo', 'LIKE', '%' . $search . '%')
                    ->orWhere('testCenterName', 'LIKE', '%' . $search . '%')
                    ->orWhere('testDate', 'LIKE', '%' . $search . '%')
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
            //     'description' => "Term: $termId, Center: $centerId, Searched: $search, DateFrom: $dateFromId, DateTo: $dateToId, Room: $roomId, Schedules List Generated",
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
            $filters = $request->only(['termID', 'centerID', 'dateFromID', 'dateToID', 'roomID', 'search', 'sort']);

            $termID = $filters['termID'] ?? 'N/A';
            $centerID = $filters['centerID'] ?? 'N/A';
            $dateFromID = $filters['dateFromID'] ?? 'N/A';
            $dateToID = $filters['dateToID'] ?? 'N/A';
            $roomID = $filters['roomID'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';
            $sort = $filters['sort'] ?? 'N/A';


            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Schedule - Applicant',
                'affectedItem' => 'Export Applicants List',
                'description' => "Term: $termID, Center: $centerID, Searched: $search, DateFrom: $dateFromID, DateTo: $dateToID,  Room: $roomID, Schedules List Exported",
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


    public function scheduleManagement()
    {

        $centers = ScheduleCenter::
            // where('isActive', 1)
            orderBy('id', 'asc')
            ->get();

        $dates = ScheduleDate::
            orderBy('id', 'asc')
            ->get();
    
        $times = ScheduleTime::
            orderBy('id', 'asc')
            ->get();
    
        $rooms = ScheduleRoom::
            orderBy('id', 'asc')
            ->get();
    
        $sessions = ScheduleSession::
            orderBy('id', 'asc')
            ->get();

        return view('Schedules.Management', compact('dates', 'centers', 'times', 'rooms', 'sessions'));
    }



}
