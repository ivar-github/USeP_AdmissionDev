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

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        session()->flash('success', $request->name . ' has been registered successfully!');
        return response()->json(['message' => $request->name . ' has been registered successfully!'], 200);

    }


    public function show(User $user)
    {
        return view('Users.Show', compact('user'));
    }


    public function edit($user)
    {
        // return view('Users.Edit', compact('user'));
        // return response()->json(compact('user'));

        $user = User::findOrFail($user);
        return response()->json($user);

    }


    public function update(Request $request, User $user)
    {
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

        // return redirect()->route('users.index', $user->id)
        //         ->with('success', ''.$request->name.' updated successfully.');

        session()->flash('success', $request->name . ' has been updated successfully!');
        return response()->json(['message' => $request->name . ' has been updated successfully!'], 200);

    }

    public function destroy(string $id)
    {
        //
    }


    public function fetch(Request $request)
    {
        if($request->ajax())
        {
            $data = User::select('*');

            return DataTables::of($data)->addIndexColumn()->make(true);
        }
        return view('users.fetch');
    }

    public function getData()
    {
        $query = User::query(); // Or any other query to fetch your data

        return DataTables::of($query)
            ->make(true);
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
