<?php

namespace App\Http\Requests\House;

use App\Http\Requests\Request;

class HouseRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'nor' => 'required|integer|min:1',
            'max_guest' => 'integer|min:1',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => trans('validation.models.house.user_id'),
            'name' => trans('validation.models.house.name'),
            'display_name' => trans('validation.models.house.display_name'),
            'nor' => trans('validation.models.house.nor'),
            'max_guest' => trans('validation.models.house.max_guest'),
            'status' => trans('validation.models.house.status'),
        ];
    }
}
