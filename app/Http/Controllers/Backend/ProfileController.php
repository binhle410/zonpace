<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Http\Requests\Backend\Access\User\UpdateProfileRequest;
use Illuminate\Support\Facades\App;

/**
 * Class UserController
 */
class ProfileController extends Controller
{
    /**
     * @var UserContract
     */
    protected $users;

    /**
     * @param UserContract $users
     */
    public function __construct(UserContract $users)
    {
        $this->middleware('backend.auth');
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $user = access()->user();
        $profile = $user->profile;
        if (!$profile) {
            $profile = App::make(\App\Models\Access\User\Profile::class);
        }
        return view('backend.profiles.index', compact('user', 'profile'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->users->updateProfile($request->all());
        return redirect()->route('backend.profile')->withFlashSuccess(trans('alerts.backend.users.updated'));
    }
}