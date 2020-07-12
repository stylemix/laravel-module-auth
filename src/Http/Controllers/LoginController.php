<?php

namespace StylemixModules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'refresh']);
    }

	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			$this->sendLockoutResponse($request);
		}

		if ($token = $this->attemptLogin($request)) {
			return $this->respondWithToken($request, $token);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Refresh a token.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh(Request $request)
	{
		return $this->respondWithToken($request, $this->guard()->refresh());
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		return $this->loggedOut($request);
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool|string
	 */
	protected function attemptLogin(Request $request)
	{
		return $this->guard()->attempt($this->credentials($request), true);
	}

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  string                   $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken(Request $request, $token)
	{
		$this->clearLoginAttempts($request);

		return Response::json([
			'token' => $token,
			'token_type' => 'bearer',
			'expires_in' => $this->guard()->factory()->getTTL() * 60
		]);
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Tymon\JWTAuth\JWTGuard
	 */
	protected function guard()
	{
		return Auth::guard('api');
	}
}
