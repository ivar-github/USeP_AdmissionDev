<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleCenter;
use App\Models\ScheduleViewSlot;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleCenterController extends Controller
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
                'Campus' => ['required', 
                    'integer',
                    'max:500',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestCenter', 'campusID'), 
                ],
                'Center' => ['required', 'string', 'max:100'],
                'Description' => ['required', 'string', 'max:255'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $center = ScheduleCenter::create([
                'campusID' => $request->Campus,
                'testCenterName' => $request->Center,
                'description' => $request->Description,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Center',
                'affectedID' => $center->id,
                'affectedItem' => $center->campusID,
                'description' => 'Test Center Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Test Center Creation Successful!',
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
        $center = ScheduleCenter::findOrFail($id);
        return response()->json($center);
    }


    public function update(Request $request)
    {

        try {

            $centerID = $request->input('centerID');
            $center = ScheduleCenter::where('id', $centerID)->firstOrFail();

            $request->validate([
                'Campus' => [
                    'required',
                    'string',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestCenter', 'campusID')
                    ->ignore($center->id, 'id'),                
                ],
                'Center' => ['required', 'string', 'max:200'],
                'Description' => ['required', 'string', 'max:255'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $center->campusID = $request->input('Campus');
            $center->testCenterName = $request->input('Center');
            $center->description = $request->input('Description');
            $center->isActive = $request->input('Status');
            $center->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($center->wasChanged()) {
                $status = 1;
                $desc = 'Test Center Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Center',
                'affectedID' => $center->id,
                'affectedItem' => $center->campusID,
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

            $isBeingUSed = ScheduleViewSlot::where('testCenterID', $id)
                ->exists();

            if ($isBeingUSed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Test Center is already being used!.'
                ], 422);
            }

            $center = ScheduleCenter::findOrFail($id);
            $center->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Center',
                'affectedID' => $center->id,
                'affectedItem' => $center->campusID,
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
