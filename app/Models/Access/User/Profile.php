<?php

namespace App\Models\Access\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = [];

    /**
     * One-to-One relations with User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
