<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\ActionLogs;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
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
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'force_pass' => 0,
        ]);

        $status = 0;
        $desc = 'No changes were made';

        if ($request->user()->wasChanged('password')) {
            $status = 1;
            $desc = 'Password Update Successful';
        }

        ActionLogs::create([
            'type' => 'Update',
            'userID' => Auth::user()->id,
            'userEmail' => Auth::user()->email,
            'module' => 'Users Password',
            'affectedID' => Auth::user()->id,
            'affectedItem' => Auth::user()->email,
            'description' => $desc,
            'status' => $status,
        ]);



        Auth::logout();
        return back()->with('status', 'password-updated');
    }


}
