<?php

namespace StylemixModules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use StylemixModules\Auth\Models\UserProxy;

class VerificationController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Email Verification Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling email verification for any
	| user that recently registered with the application. Emails may also
	| be re-sent if the user didn't receive the original email message.
	|
	*/

	use VerifiesEmails;

	/**
	 * Where to redirect users after verification.
	 *
	 * @var string
	 */
	protected $redirectTo = '';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}

	/**
	 * Mark the authenticated user's email address as verified.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function verify(Request $request)
	{
		/** @var \StylemixModules\Auth\Models\User $user */
		if (!($user = UserProxy::find($request->route('id')))) {
			throw new AuthorizationException;
		}

		if ($user->hasVerifiedEmail()) {
			return view('auth.verified');
		}

		if ($user->markEmailAsVerified()) {
			event(new Verified($request->user()));
		}

		return view('auth.verified');
	}
}
