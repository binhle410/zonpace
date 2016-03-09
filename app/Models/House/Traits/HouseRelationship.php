<?php

namespace App\Models\House\Traits;

use App\Models\Access\User\User;

trait HouseRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}