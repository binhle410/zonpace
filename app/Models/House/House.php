<?php

namespace App\Models\House;

use App\Models\House\Traits\HouseAttribute;
use App\Models\House\Traits\HouseRelationship;
use Illuminate\Database\Eloquent\Model;

/**
 * Class House
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $display_name
 * @property int $nor
 * @property int $max_guest
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class House extends Model
{
    use HouseRelationship, HouseAttribute;

    protected $table = 'houses';
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'name', 'display_name', 'nor', 'max_guest', 'status'];
}
