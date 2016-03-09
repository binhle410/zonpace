<?php

namespace App\Http\Requests\House;


class StoreHouseRequest extends HouseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo Apply Permission
        return true;
    }
}
