<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Term;
use App\Models\ScheduleApplicants;
use App\Models\ScheduleViewSlot;
use App\Models\ScheduleCenter;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleRescheduleController extends Controller
{
    public function index()
    {

        try {

            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->where('IsForAdmission', 1)
                ->orderBy('TermID', 'desc')
                ->get();


            $testCenters = ScheduleCenter::select('id', 'campusID', 'testCenterName', 'description')
                ->where('isActive',1)
                ->limit(10)
                ->orderBy('id', 'asc')
                ->get();

            return view('Schedules.Reschedules.Index', compact('terms', 'testCenters'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create()
    {
       // return view('Employees.Create');
    }


    public function show(Employee $employee)
    {
        // return view('Employees.Show', compact('employee'));
    }



    public function edit(Request $request, string $id): JsonResponse
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $applicant = ScheduleApplicants::from('CUSTOM_AdmissionApplicantTestSchedule as sa')
                ->select(
                    'sa.id',
                    'sa.appNo',
                    'sa.testScheduleCode',
                    'sa.testCenterID',
                    'sa.testDateID',
                    'sa.testTimeID',
                    'sa.testSessionID',
                    'sa.testRoomID',
                    'sa.termID',
                    'reg.AppNo',
                    'reg.Choice1_CampusID as campusID',
                    'reg.LastName',
                    'reg.FirstName',
                    'reg.MiddleName',
                    'reg.ExtName',
                    'sa_view.AppNo',
                    'sa_view.Name',
                    'sa_view.testCenterName',
                    'sa_view.testDate',
                    'sa_view.testTimeStartString',
                    'sa_view.testTimeEndString',
                    'sa_view.testRoomName'
                )
                ->leftJoin('ES_Admission as reg', 'reg.AppNO', '=', 'sa.appNo')
                ->leftJoin('vw_CUSTOM_AdmissionApplicantTestSchedules as sa_view', 'sa_view.AppNO', '=', 'sa.appNo')
                ->where('sa.id', $id)
                ->first();

            if (!$applicant) {
                return response()->json([
                    'message' => 'Applicant not found!',
                    'status' => 'error',
                ], 404);
            }

            return response()->json($applicant);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $applicantID = $request->input('applicantID');

            if ($applicantID == 0) {
                return response()->json([
                    'error' => 'Please select an applicant',
                    'message' => 'Please select an applicant before proceeding.',
                ], 400);
            }

            $applicantSched = ScheduleApplicants::where('id', $applicantID)->firstOrFail();

            $request->validate([
                'Term' => ['required', 'integer'],
                'Center' => ['required', 'integer', 'max:100'],
                'Date' => ['required', 'integer', 'max:100'],
                'Time' => ['required', 'integer', 'max:100'],
                'Room' => ['required', 'integer', 'max:100'],
                'Session' => ['required', 'integer', 'max:100'],
            ]);

            $applicantSched->termID = $request->input('Term');
            $applicantSched->testCenterID = $request->input('Center');
            $applicantSched->testDateID = $request->input('Date');
            $applicantSched->testTimeID = $request->input('Time');
            $applicantSched->testRoomID = $request->input('Room');
            $applicantSched->testSessionID = $request->input('Session');
            $applicantSched->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($applicantSched->wasChanged()) {

                $applicantSched->dateModified = now();
                $applicantSched->save();

                $status = 1;
                $desc = 'Rescheduling Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Applicant',
                'affectedID' => $applicantSched->id,
                'affectedItem' => $applicantSched->appNo,
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


    public function search(Request $request)
    {

    }


    public function getAvailableScheds(Request $request): JsonResponse
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $centerID = $request->input('centerID');

            $ScheduleSlots = ScheduleViewSlot::select('id',
                    'termID',
                    'testCenterID',
                    'testDateID',
                    'testTimeID',
                    'testSessionID',
                    'testRoomID',
                    'termID',
                    'testCenterName',
                    'testDate',
                    'testTimeStartString',
                    'testTimeEndString',
                    'testRoomName',
                    'availableSlots',
                    'totalRegistered',
                    'isFull',
                    'isActive'
                )
                ->where('isFull', 'false')
                ->where('isActive', 1)
                ->where('testCenterID', $centerID)
                ->where('testDate', '>', now())
                ->orderBy('testCenterID')
                ->orderBy('testDate')
                ->orderBy('testSessionName')
                ->get();

            if (!$ScheduleSlots) {
                return response()->json(['error' => 'Schedules not found or unavailable'], 404);
            }

            return response()->json($ScheduleSlots, 200);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function selectSchedDetails(Request $request): JsonResponse
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $schedID = $request->input('e_slotID');

            $ScheduleDetails = ScheduleViewSlot::select(
                'id', 'termID', 'testCenterID', 'testDateID', 'testTimeID', 'testSessionID',
                'testRoomID', 'termID', 'testCenterName', 'testDate', 'testTimeStartString',
                'testTimeEndString', 'testRoomName', 'availableSlots', 'totalRegistered',
                'isFull', 'isActive'
            )->where('id', $schedID)
            ->first();

            if (!$ScheduleDetails) {
                return response()->json(['error' => 'Schedule details not found or unavailable'], 404);
            }

            return response()->json($ScheduleDetails, 200);

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

            $search = $request->input('examinee');
            $termId = $request->input('termID');

            if ($search == '') {
                return response()->json([
                    'error' => "Invalid data",
                    'message' => "Please input Applicant's number or name !",
                ], 400);
            }

            $query = ScheduleApplicants::from('CUSTOM_AdmissionApplicantTestSchedule as sa')
            ->select(
                'sa.id',
                'sa.appNo',
                'sa.testScheduleCode',
                'sa.testCenterID',
                'sa.testDateID',
                'sa.testTimeID',
                'sa.testSessionID',
                'sa.testRoomID',
                'sa.termID',
                'reg.AppNo',
                'reg.Choice1_CampusID as campusID',
                'reg.LastName',
                'reg.FirstName',
                'reg.MiddleName',
                'reg.ExtName',
                'sa_view.AppNo',
                'sa_view.Name',
                'sa_view.testCenterName',
                'sa_view.testDate',
                'sa_view.testTimeStartString',
                'sa_view.testTimeEndString',
                'sa_view.testRoomName'
            )
            ->leftJoin('ES_Admission as reg', 'reg.AppNo', '=', 'sa.appNo')
            ->leftJoin('vw_CUSTOM_AdmissionApplicantTestSchedules as sa_view', function ($join) {
                $join->on('sa_view.AppNo', '=', 'sa.appNo')
                        ->on('sa_view.testScheduleCode', '=', 'sa.testScheduleCode');
            })
            ->orderBy('sa.appNo', 'desc')
            ->limit(10);

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sa.appNo', 'LIKE', '%' . $search . '%')
                    ->orWhere('sa.testCenterID', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.LastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.FirstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.MiddleName', 'LIKE', '%' . $search . '%');
                });
            }

            if ($termId) {
                $query->where('sa.termID', $termId);
            }

            $examinees = $query->get();

            return response()->json([
                'examinees' => $examinees
            ]);

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

            $appNo = $request->input('appNo');

            $hasMoreThanOneRow = ScheduleApplicants::where('appNo', $appNo)
                ->havingRaw('COUNT(*) > 1')
                ->exists();

            if (!$hasMoreThanOneRow) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Applicant schedule could not be deleted!'
                ], 422);
            }

            $applicantSched = ScheduleApplicants::findOrFail($id);
            $applicantSched->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Applicant',
                'affectedID' => $applicantSched->id,
                'affectedItem' => $applicantSched->appNo,
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
