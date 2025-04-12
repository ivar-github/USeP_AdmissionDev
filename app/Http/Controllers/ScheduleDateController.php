<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleDate;
use App\Models\ScheduleViewSlot;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleDateController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $request->validate([
                'Date' => [
                    'required',
                    'string',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestDate', 'testDate'),
                ],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $date = ScheduleDate::create([
                'testDate' => $request->Date,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Date',
                'affectedID' => $date->id,
                'affectedItem' => $date->testDate,
                'description' => 'Test Date Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Test Date Creation Successful!',
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


    public function edit(Request $request, string $id)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {
            $date = ScheduleDate::findOrFail($id);
            return response()->json($date);

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

            $dateID = $request->input('dateID');
            $date = ScheduleDate::where('id', $dateID)->firstOrFail();

            $request->validate([
                'Date' => [
                    'required',
                    'string',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestDate', 'testDate')
                    ->ignore($date->id, 'id'),
                ],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $date->testDate = $request->input('Date');
            $date->isActive = $request->input('Status');
            $date->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($date->wasChanged()) {
                $status = 1;
                $desc = 'Test Date Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Date',
                'affectedID' => $date->id,
                'affectedItem' => $date->testDate,
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


        }  catch (ValidationException $e) {
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


    public function destroy(Request $request, string $id)
    {

        if (!$request->ajax()) {
            abort(403);
        }

        try {

            $isBeingUSed = ScheduleViewSlot::where('testDateID', $id)
                ->exists();

            if ($isBeingUSed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Test Date is already being used!.'
                ], 422);
            }

            $date = ScheduleDate::findOrFail($id);
            $date->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Date',
                'affectedID' => $date->id,
                'affectedItem' => $date->testDate,
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
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
