<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Access\Traits\Backend\ChangePasswords;
use App\Services\Access\Traits\Backend\ResetPasswords;
use App\Repositories\Backend\User\UserContract;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Backend\Auth
 */
class PasswordController extends Controller
{
    use ChangePasswords, ResetPasswords;

    /**
     * Where to redirect the user after their password has been successfully reset
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    protected $password;

    //protected $broker = 'backend';

    /**
     * PasswordController constructor.
     *
     * @param UserContract $user
     */
    public function __construct(UserContract $user)
    {
        $this->user = $user;
    }
}