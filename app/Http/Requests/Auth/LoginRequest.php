<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\LoginLogs;
use Jenssegers\Agent\Agent;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $agent = new Agent();
        $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // RateLimiter::hit($this->throttleKey());
            RateLimiter::hit($this->throttleKey(), 3600);

            LoginLogs::create([
                'userEmail' => $this->input('email'),
                'description' => 'Login Failed',
                'status' => 0,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if ($user->status == 0) {

            LoginLogs::create([
                'userID' => $user->id,
                'userEmail' => $user->email,
                'description' => 'Deactivated Account Attempted',
                'status' => 0,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            Auth::logout();

            throw ValidationException::withMessages([
                'inactive' => 'Your Account Is Deactivated!!',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        // throw ValidationException::withMessages([
        //     'email' => trans('auth.throttle', [
        //         'seconds' => $seconds,
        //         'minutes' => ceil($seconds / 60),
        //     ]),
        // ]);

        $minutes = ceil(RateLimiter::availableIn($this->throttleKey()) / 60);

        throw ValidationException::withMessages([
            'email' => "Too many login attempts.
             Please try again in {$minutes} minute(s).",
            // 'email' => 'Too many login attempts. Please try again in 1 hour.',
        ]);


    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
