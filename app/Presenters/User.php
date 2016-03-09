<?php

namespace App\Presenters;

use App\Contracts\Presentable;

class User extends Presenter
{
    /**
     * Present the full name
     * 
     * @return string
     */
    public function fullName()
    {
        return $this->entity->first_name . ' ' . $this->entity->last_name;
    }

}
