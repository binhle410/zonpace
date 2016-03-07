<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class UpdateProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'User.email' => 'required|email',
            'User.username' => 'required|string',
            'User.first_name' => 'required|string',
            'User.last_name' => 'required|string',
            'User.phone' => 'required|numeric',
            'Profile.work' => 'required|string',
            'Profile.timezone' => 'required|timezone',
            'Profile.locale' => 'required|string',
        ];
    }
}
