<?php

namespace App\Services\Access\Traits\Backend;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Services\Access\Traits\RedirectsUsers;
use App\Http\Requests\Backend\Auth\ResetPasswordRequest;
use App\Http\Requests\Backend\Auth\SendResetLinkEmailRequest;

/**
 * Class ResetsPasswords
 * @package App\Services\Access\Traits
 */
trait ResetPasswords
{
    use RedirectsUsers;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('backend.auth.passwords.email');
    }

    /**
     * @param SendResetLinkEmailRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(SendResetLinkEmailRequest $request)
    {
        Password::setDefaultDriver('backend');

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(trans('strings.emails.auth.password_reset_subject'));
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * @param null $token
     * @return $this
     */
    public function showResetForm($token = null)
    {
        if (is_null($token)) {
            return $this->showLinkRequestForm();
        }

        return view('backend.auth.passwords.reset')
            ->with('token', $token);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath())->with('status', trans($response));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * @param $user
     * @param $password
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
        auth()->login($user);
    }
}
