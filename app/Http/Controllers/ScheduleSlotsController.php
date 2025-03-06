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

use App\Exports\ExportScheduleSlot;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleSlotsController extends Controller
{
 
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

            $dates = ScheduleDate::select('id', 'testDate')
                ->where('isActive', 1)
                ->orderBy('testDate', 'asc')->get();

            $times = ScheduleTime::select('id', 'testTimeStartString', 'testTimeEndString')
                ->where('isActive', 1)
                ->orderBy('testTimeStartString', 'asc')->get();

            $sessions = ScheduleSession::select('id', 'testSessionName' )
                ->where('isActive', 1)
                ->orderBy('id', 'asc')->get();

            $rooms = ScheduleRoom::select('id', 'testRoomName' )
                ->where('isActive', 1)
                ->orderBy('testRoomName', 'asc')->get();

            return view('Schedules.ScheduleSlots', compact('terms', 'centers', 'dates',  'times', 'sessions', 'rooms'  ));

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
            $status = $request->input('status');
            // $isVacant = $request->boolean('isVacant', false) ? 'False' : 'True';
            $isVacant = $request->boolean('isVacant', false);

            $prefRowQuery = ScheduleViewSlot::select($columns)
                ->where('TermID', $termId)
                ->when($centerId != 0, fn($query) => $query->where('testCenterID', $centerId))
                ->when($roomId != 0, fn($query) => $query->where('testRoomID', $roomId))
                ->when($dateFromId && $dateToId, fn($query) => $query->whereBetween('testDate', [$dateFromId, $dateToId]))
                ->when($dateFromId && !$dateToId, fn($query) => $query->where('testDate', '>=', $dateFromId))
                ->when(!$dateFromId && $dateToId, fn($query) => $query->where('testDate', '<=', $dateToId))
                ->when($isVacant, fn($query) => $query->where('isFull', 'False'))
                ->where('isActive', $status)
                // ->where('isFull', '=', $isVacant)
                ->orderBy('testCenterName', 'asc') 
                ->orderBy('testDate', 'asc') 
                ->when($sort, fn($query) => $query->orderBy($sort, 'asc'));


            if ($search) {
                $prefRowQuery->where(function($q) use ($search) {
                    $q->where('testDate', 'LIKE', '%' . $search . '%')
                    ->orWhere('testTimeStartString', 'LIKE', '%' . $search . '%')
                    ->orWhere('testSessionName', 'LIKE', '%' . $search . '%')
                    ->orWhere('testRoomName', 'LIKE', '%' . $search . '%');
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


    public function exportSchedulesSlots(Request $request)
    {
        try {

            $columns = explode(',', $request->input('columns', ''));
            $filters = $request->only(['termID', 'centerID', 'dateFromID', 'dateToID',  'roomID', 'search', 'status', 'sort']);

            $termID = $filters['termID'] ?? 'N/A';
            $centerID = $filters['centerID'] ?? 'N/A';
            $dateFromID = $filters['dateFromID'] ?? 'N/A';
            $dateToID = $filters['dateToID'] ?? 'N/A';
            $roomID = $filters['roomID'] ?? 'N/A';
            $search = $filters['search'] ?? 'N/A';
            $sort = $filters['sort'] ?? 'N/A';
            $status = $filters['status'] ?? 'N/A';


            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Read',
                'module' => 'USePAT Schedule - Slot',
                'affectedItem' => 'Export Schedlue Slot List',
                'description' => "Term: $termID, Center: $centerID, Searched: $search, DateFrom: $dateFromID, DateTo: $dateToID, Room: $roomID, Status: $status,  Slots List Exported",
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);


            return Excel::download(new ExportScheduleSlot($columns, $filters), 'schedulesSlots-data.xlsx');

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

        try {
            $request->validate([
                'Term' => ['required', 'integer'],
                'Center' => ['required', 'integer'],
                'Date' => ['required', 'integer'],
                'Time' => ['required', 'integer'],
                'Session' => ['required', 'integer'],
                'Room' => ['required', 'integer'],
                'Slot' => ['required', 'integer', 'max:200'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);
 
            $existingSchedule = ScheduleSlot::where([
                'termID' => $request->Term,
                'testCenterID' => $request->Center,
                'testDateID' => $request->Date,
                'testTimeID' => $request->Time,
                'testSessionID' => $request->Session,
                'testRoomID' => $request->Room,
            ])->exists();
    
            if ($existingSchedule) {
                return response()->json([
                    'message' => 'A schedule with the same details already exists!',
                    'status' => 'error',
                ], 409);  
            }

            $scheduleSlot = ScheduleSlot::create([
                'termID' => $request->Term,
                'testCenterID' => $request->Center,
                'testDateID' => $request->Date,
                'testTimeID' => $request->Time,
                'testSessionID' => $request->Session,
                'testRoomID' => $request->Room,
                'maxExamineeSlots' => $request->Slot,
                'dateAdded' => now(),
                'createdBy' => Auth::user()->email,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Slot',
                'affectedID' => $scheduleSlot->id,
                'affectedItem' => $scheduleSlot->testCenterID.','
                    .$scheduleSlot->testDateID.','
                    .$scheduleSlot->testTimeID.','
                    .$scheduleSlot->testRoomID.','
                    .$scheduleSlot->testSessionID.','
                    .$scheduleSlot->termID.','
                    .$scheduleSlot->maxExamineeSlots.','
                    .$scheduleSlot->isActive.',',
                'description' => 'Schedule Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Schedule Creation Successful!',
                'status' => 'success',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function show(string $id)
    {
        //
    }


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
                    'maxExamineeSlots',
                    'isActive',
                )
                ->where('id', $id)
                ->first(); 

            if (!$slot) {
                return response()->json([
                    'message' => 'Schedule slot not found!',
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


    public function update(Request $request)
    {

        try {

            $slotID = $request->input('slotID');

            $request->validate([
                'Term' => ['required', 'integer'],
                'Center' => ['required', 'integer'],
                'Date' => ['required', 'integer'],
                'Time' => ['required', 'integer'],
                'Session' => ['required', 'integer'],
                'Room' => ['required', 'integer'],
                'Slot' => ['required', 'integer', 'max:200'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);
 
            $existingSchedule = ScheduleSlot::where([
                'termID' => $request->Term,
                'testCenterID' => $request->Center,
                'testDateID' => $request->Date,
                'testTimeID' => $request->Time,
                'testSessionID' => $request->Session,
                'testRoomID' => $request->Room,
            ])
            ->where('id', '!=', $slotID)
            ->exists();
    
            if ($existingSchedule) {
                return response()->json([
                    'message' => 'A schedule with the same details already exists!',
                    'status' => 'error',
                ], 409);  
            }

            $scheduleSlot = ScheduleSlot::where('id', $slotID)->firstOrFail();

            $scheduleSlot->testCenterID = $request->input('Center');
            $scheduleSlot->testDateID = $request->input('Date');
            $scheduleSlot->testTimeID = $request->input('Time');
            $scheduleSlot->testRoomID = $request->input('Room');
            $scheduleSlot->testSessionID = $request->input('Session');
            $scheduleSlot->termID = $request->input('Term');
            $scheduleSlot->maxExamineeSlots = $request->input('Slot');
            $scheduleSlot->isActive = $request->input('Status');
            $scheduleSlot->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($scheduleSlot->wasChanged()) {
                $status = 1;
                $desc = 'Schedule Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Slot',
                'affectedID' => $scheduleSlot->id,
                'affectedItem' => $scheduleSlot->testCenterID.','
                    .$scheduleSlot->testDateID.','
                    .$scheduleSlot->testTimeID.','
                    .$scheduleSlot->testRoomID.','
                    .$scheduleSlot->testSessionID.','
                    .$scheduleSlot->termID.','
                    .$scheduleSlot->maxExamineeSlots.','
                    .$scheduleSlot->isActive.',',
                'description' => $desc,
                'status' => $status,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Applicant not found',
                'message' => 'The requested applicant does not exist.',
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function destroy(Request $request, string $id)
    {
        try {

            $isBeingUsed = ScheduleViewSlot::where('id', $id)
                ->where('totalRegistered', '>', 0)
                ->exists();
    
            if ($isBeingUsed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The schedule slot is already being used!'
                ], 422);
            }

            $scheduleSlot = ScheduleSlot::findOrFail($id);
            $scheduleSlot->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Slot',
                'affectedID' => $scheduleSlot->id,
                'affectedItem' => $scheduleSlot->testCenterID.','
                    .$scheduleSlot->testDateID.','
                    .$scheduleSlot->testTimeID.','
                    .$scheduleSlot->testRoomID.','
                    .$scheduleSlot->testSessionID.','
                    .$scheduleSlot->termID.','
                    .$scheduleSlot->maxExamineeSlots.','
                    .$scheduleSlot->isActive.',',
                'description' => 'Deletion Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);


            return response()->json([
                'status' => 'success',
                'message' => 'Deletion Successful'
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
