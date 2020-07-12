<?php

namespace StylemixModules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

	protected function sendResetResponse(Request $request, $response)
	{
		return $request->wantsJson() ?
			Response::json([
				'message' => trans($response),
			]) :
			Redirect::back()
				->with('status', trans($response));
	}

	protected function sendResetFailedResponse(Request $request, $response)
	{
		return $request->wantsJson() ?
			Response::json([
				'errors' => [
					'email' => [trans($response)],
				],
			], 422) :
			Redirect::back()
				->withInput($request->only('email'))
				->withErrors(['email' => trans($response)]);
	}
}
