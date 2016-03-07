<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Access\Traits\ConfirmUsers;
use App\Services\Access\Traits\UseSocialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Repositories\Backend\User\UserContract;
use App\Services\Access\Traits\AuthenticatesAndRegistersUsers;
use App\Http\Requests\Request;
use App\Exceptions\GeneralException;
use App\Events\Frontend\Auth\UserLoggedIn;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ConfirmUsers, ThrottlesLogins, UseSocialite;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Where to redirect users after they logout
     *
     * @var string
     */
    protected $redirectAfterLogout = '/admin/login';

    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        /**
         * Check to see if the users account is confirmed and active
         */
        if (! access()->user()->isConfirmed()) {
            $token = access()->user()->confirmation_code;
            auth()->logout();
            throw new GeneralException(trans('exceptions.frontend.auth.confirmation.resend', ['token' => $token]));
        } elseif (! access()->user()->isActive()) {
            auth()->logout();
            throw new GeneralException(trans('exceptions.frontend.auth.deactivated'));
        } elseif(! access()->allow('view-backend')) {
            auth()->logout();
            throw new GeneralException(trans('exceptions.backend.auth.permissions.view_backend_error'));
        }

        event(new UserLoggedIn(access()->user()));
        return redirect()->intended($this->redirectPath());
    }
}