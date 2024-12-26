<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{


    public function index()
    {
        $users = User::all();

        return view('Users.Index', compact('users'));
    }

    public function create()
    {
        return view('Users.Create');
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
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
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
            event(new Registered($user));

            return response()->json([
                'message' => 'User created successfully!',
                'status' => 'success',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }

    }


    public function show(User $user)
    {
        return view('Users.Show', compact('user'));
    }


    public function edit($user)
    {

        $user = User::findOrFail($user);
        return response()->json($user);

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

            if ($user->wasChanged()) {
                return response()->json([
                    'message' => 'User updated successfully!',
                    'status' => 'success',
                ], 200);
            }else{
                return response()->json([
                    'message' => 'No changes were made!',
                    'status' => 'success',
                ], 200);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred!',
                'status' => 'error',
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }


}
