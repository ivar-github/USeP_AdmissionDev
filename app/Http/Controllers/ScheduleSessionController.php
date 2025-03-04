<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleSession;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleSessionController extends Controller
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
                'Session' => [
                    'required',
                    'string',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestSession', 'testSessionName'),                
                ],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $session = ScheduleSession::create([
                'testSessionName' => $request->Session,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Session',
                'affectedID' => $session->id,
                'affectedItem' => $session->testSessionName,
                'description' => 'Test Session Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Test Session Creation Successful!',
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
        $session = ScheduleSession::findOrFail($id);
        return response()->json($session);
    }


    public function update(Request $request)
    {

        try {

            $sessionID = $request->input('sessionID');
            $session = ScheduleSession::where('id', $sessionID)->firstOrFail();

            $request->validate([
                'Session' => [
                    'required',
                    'string',
                    Rule::unique('sqlsrv2.CUSTOM_AdmissionTestSession', 'testSessionName')
                    ->ignore($session->id, 'id'),                
                ],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $session->testSessionName = $request->input('Session');
            $session->isActive = $request->input('Status');
            $session->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($session->wasChanged()) {
                $status = 1;
                $desc = 'Test Session Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Session',
                'affectedID' => $session->id,
                'affectedItem' => $session->testSessionName,
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

            // $isActive = ActionLogs::where('userID', $id)
            //     ->exists();

            // if ($isActive) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'User has action logs.'
            //     ], 422);
            // }

            $session = ScheduleSession::findOrFail($id);
            $session->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Session',
                'affectedID' => $session->id,
                'affectedItem' => $session->testSessionName,
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
