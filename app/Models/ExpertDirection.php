<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\ExpertDirection
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $base_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection whereBaseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertDirection whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsExistDirection[] $existingDirections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsPossibleDirection[] $possibleDirections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertSpec[] $specs
 */
class ExpertDirection extends Model
{

    protected $table ='expert_directions';

    public function existingDirections()
    {
        return $this->hasMany(ExpertsExistDirection::class,'direction_id');
    }
    public function possibleDirections()
    {
        return $this->hasMany(ExpertsPossibleDirection::class,'direction_id');
    }
    public function specs()
    {
        return $this->hasMany(ExpertSpec::class,'direction_id');
    }
}
