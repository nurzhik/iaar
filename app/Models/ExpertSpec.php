<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\ExpertSpec
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $code
 * @property int|null $direction_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertSpec whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ExpertDirection|null $direction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsExistDirection[] $existingDirections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsPossibleDirection[] $possibleDirections
 */
class ExpertSpec extends Model
{

    protected $table ='expert_specializations';

    public function existingDirections()
    {
        return $this->hasMany(ExpertsExistDirection::class,'spec_id');
    }
    public function possibleDirections()
    {
        return $this->hasMany(ExpertsPossibleDirection::class,'spec_id');
    }
    public function direction()
    {
        return $this->belongsTo(ExpertDirection::class,'direction_id');
    }
}
