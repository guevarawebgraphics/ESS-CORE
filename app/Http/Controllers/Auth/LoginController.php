<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
    * Override the username method used to validate login
    *Custom For Username Login
    * @return string
    */
    public function username()
    {
        return 'username';
    }
    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['username' => $request->{$this->username()}, 'password' => $request->password, 'AccountStatus' => 1];
    }
    /**
     * Authenticate the Expire User or Account the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function authenticated(\Illuminate\Http\Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        $updated_at = $user->updated_at;
        $expiry_date = $user->expiry_date;
        $password_expiry_at = Carbon::parse($updated_at)->addDays($expiry_date);
        if($password_expiry_at->lessThan(Carbon::now())){
            // Check if the user is not yet Verified
            if($user->expiry_date == "14") {
                $errors = [$this->username() => trans('auth.expired')];
                auth()->logout();
                return redirect('login')->withErrors($errors);
            }
        }
        // return redirect()->back()
        //             ->withInput($request->only($this->username(), 'remember'))
        //             ->withErrors($errors);

    }
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users',
            'password' => 'required',
        ],
        [
            $this->username() . '.exists' => 'The Username is Invalid.'
        ]);
    }
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user->AccountStatus != 1) {
            $errors = [$this->username() => trans('auth.deactivated')];
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
