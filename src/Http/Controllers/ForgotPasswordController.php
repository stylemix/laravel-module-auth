<?php

namespace StylemixModules\Auth\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	protected function sendResetLinkResponse(Request $request, $response)
	{
		return $request->wantsJson() ?
			['message' => trans($response)] :
			Redirect::back()->with('status', trans($response));
	}

	protected function sendResetLinkFailedResponse(Request $request, $response)
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
