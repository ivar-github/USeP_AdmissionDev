<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginLogs;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class AuthenticatedSessionController extends Controller
{

    /**
     * LOGIN PAGE
     */
    public function create(): View
    {
        return view('auth.Login');
    }

    /**
     * HANDLE LOGINs
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        $agent = new Agent();
        $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

        LoginLogs::create([
            'userID' => $user->id,
            'userEmail' => $user->email,
            'description' => 'Login Successful',
            'hostName' => gethostname(),
            'platform' => $agentInfo,
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }


    public function edit(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * LOGOUT
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
