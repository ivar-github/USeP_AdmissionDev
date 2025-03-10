<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleTime;
use App\Models\ScheduleViewSlot;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleTimeController extends Controller
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

        try {
            $request->validate([
                'Time_Start' => ['required', 'string'],
                'Time_End' => ['required', 'string'],
                'Start_Value' => ['required', 'integer'],
                'End_Value' => ['required', 'integer'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $time = ScheduleTime::create([
                'testTimeStartString' => $request->Time_Start,
                'testTimeEndString' => $request->Time_End,
                'testTimeStart' => $request->Start_Value,
                'testTimeEnd' => $request->End_Value,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Time',
                'affectedID' => $time->id,
                'affectedItem' => $time->testTimeStartString.'-'.$time->testTimeEndString,
                'description' => 'Test Time Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Test Time Creation Successful!',
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


    public function edit(string $id)
    {
        $time = ScheduleTime::findOrFail($id);
        return response()->json($time);
    }


    public function update(Request $request)
    {

        try {

            $timeID = $request->input('timeID');
            $time = ScheduleTime::where('id', $timeID)->firstOrFail();

            $request->validate([
                'Time_Start' => ['required', 'string'],
                'Time_End' => ['required', 'string'],
                'Start_Value' => ['required', 'integer'],
                'End_Value' => ['required', 'integer'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $time->testTimeStartString = $request->input('Time_Start');
            $time->testTimeEndString = $request->input('Time_End');
            $time->testTimeStart = $request->input('Start_Value');
            $time->testTimeEnd = $request->input('End_Value');
            $time->isActive = $request->input('Status');
            $time->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($time->wasChanged()) {
                $status = 1;
                $desc = 'Test Time Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Time',
                'affectedID' => $time->id,
                'affectedItem' => $time->testTimeStartString.'-'.$time->testTimeEndString,
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


    public function destroy(string $id)
    {
        try {

            $isBeingUSed = ScheduleViewSlot::where('testTimeID', $id)
                ->exists();

            if ($isBeingUSed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Test Time is already being used!.'
                ], 422);
            }

            $time = ScheduleTime::findOrFail($id);
            $time->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Time',
                'affectedID' => $time->id,
                'affectedItem' => $time->testTimeStartString.'-'.$time->testTimeEndString,
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
