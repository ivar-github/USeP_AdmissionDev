<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ActionLogs;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $status = 0;
        $desc = 'No changes were made';
        if ($request->user()->wasChanged()) {
            $status = 1;
            $desc = 'Fullname and Email updated successfully';
        }

        ActionLogs::create([
            'type' => 'Update',
            'userID' => Auth::user()->id,
            'userEmail' => Auth::user()->email,
            'module' => 'Users Profile',
            'affectedID' => Auth::user()->id,
            'affectedItem' => $request->input('name').' - '.$request->input('email'),
            'description' => $desc,
            'status' => $status,
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
