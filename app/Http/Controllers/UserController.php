<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Illuminate\Validation\ValidationException;
use Exception;
use Throwable;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{


    public function index()
    {

        try {

            $users = User::all();
            return view('Users.Index', compact('users'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        // return view('Users.Create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    public function store(Request $request)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'password' => [
                    'required',
                    // 'confirmed',
                    Password::min(8)
                        //->mixedCase()
                        // ->letters()
                        // ->numbers()
                        // ->symbols()
                        ->uncompromised(),
                ],
                'type' => ['required', 'integer', 'in:0,1'],
                'status' => ['required', 'integer', 'in:0,1'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => $request->type,
                'status' => $request->status,
            ]);

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();
            
            ActionLogs::create([
                'type' => 'Create',
                'module' => 'Users',
                'affectedID' => $user->id,
                'affectedItem' => $user->name,
                'description' => 'User Creation Successful',
                'status' => 1,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            event(new Registered($user));

            return response()->json([
                'message' => 'User Creation Successful',
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


    public function show(User $user)
    {
        // return view('Users.Show', compact('user'));
    }


    public function edit($user)
    {
        try {

            $user = User::findOrFail($user);
            return response()->json($user);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function update(Request $request, User $user)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
                'type' => ['required', 'integer', 'in:0,1'],
                'status' => ['required', 'integer', 'in:0,1'],
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
            ]);

            $status = 0;
            $desc = 'No changes were made';
            if ($user->wasChanged()) {
                $status = 1;
                $desc = 'User Update Successful';
            }
            
            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();
            ActionLogs::create([
                'type' => 'Update',
                'module' => 'Users',
                'affectedID' => $user->id,
                'affectedItem' => $request->name,
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

    public function resetPassword(Request $request)
    {

        try {

            $userId = $request->input('userIdPw');
            $user = User::where('id', $userId)->firstOrFail();

            $request->validate([
                'password' => [
                    'required',
                    Password::min(8)
                        ->uncompromised(),
                ],
            ]);

            $user->password = Hash::make($request->password);
            $user->force_pass = 1;
            $user->save();


            $status = 0;
            $desc = 'Password Reset Failed';
            if ($user->wasChanged()) {
                $status = 1;
                $desc = 'Password Reset Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();
            ActionLogs::create([
                'type' => 'Update',
                'module' => 'Users',
                'affectedID' => $user->id,
                'affectedItem' => $user->name,
                'description' => $desc,
                'status' => $status,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' =>   $desc,
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

            $isActive = ActionLogs::where('userID', $id)
                ->exists();

            if ($isActive) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User has action logs.'
                ], 422);
            }

            $user = User::findOrFail($id);
            $user->delete();

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Delete',
                'module' => 'Users',
                'affectedID' => $user->id,
                'affectedItem' => $user->name,
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
