<?php

namespace App\Services\Access\Traits\Backend;

use App\Http\Requests\Frontend\User\ChangePasswordRequest;

/**
 * Class ChangePasswords
 * @package App\Services\Access\Traits\Backend
 */
trait ChangePasswords
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('backend.auth.passwords.change');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request->all());

        return redirect()->route('admin.dashboard')->withFlashSuccess(trans('strings.frontend.user.password_updated'));
    }
}