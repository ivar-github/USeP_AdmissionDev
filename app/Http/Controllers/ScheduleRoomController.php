<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleRoom;
use App\Models\ScheduleViewSlot;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class ScheduleRoomController extends Controller
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
                'Room' => ['required', 'string', 'max:200'],
                'Description' => ['required', 'string', 'max:200'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $room = ScheduleRoom::create([
                'testRoomName' => $request->Room,
                'description' => $request->Description,
                'isActive' => $request->Status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Create',
                'module' => 'USePAT Schedule - Room',
                'affectedID' => $room->id,
                'affectedItem' => $room->testRoomName,
                'description' => 'Test Room Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => 'Test Room Creation Successful!',
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
        $room = ScheduleRoom::findOrFail($id);
        return response()->json($room);
    }


    public function update(Request $request)
    {

        try {

            $roomID = $request->input('roomID');
            $room = ScheduleRoom::where('id', $roomID)->firstOrFail();

            $request->validate([
                'Room' => ['required', 'string', 'max:200'],
                'Description' => ['required', 'string', 'max:200'],
                'Status' => ['required', 'integer', 'in:0,1'],
            ]);

            $room->testRoomName = $request->input('Room');
            $room->description = $request->input('Description');
            $room->isActive = $request->input('Status');
            $room->save();


            $status = 0;
            $desc = 'No changes were made';
            if ($room->wasChanged()) {
                $status = 1;
                $desc = 'Test Room Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'USePAT Schedule - Room',
                'affectedID' => $room->id,
                'affectedItem' => $room->testRoomName,
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

            $isBeingUSed = ScheduleViewSlot::where('testRoomID', $id)
                ->exists();

            if ($isBeingUSed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Test Room is already being used!.'
                ], 422);
            }

            $room = ScheduleRoom::findOrFail($id);
            $room->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'USePAT Schedule - Room',
                'affectedID' => $room->id,
                'affectedItem' => $room->testRoomName,
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
