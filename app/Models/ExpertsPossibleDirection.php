<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ExpertsPossibleDirection
 *
 * @property int $id
 * @property int|null $expert_id
 * @property int|null $accr_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereAccrType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereExpertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $direction_id
 * @property int|null $spec_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereSpecId($value)
 * @property-read \App\Models\ExpertSpec|null $spec
 * @property-read \App\Models\ExpertDirection|null $direction
 * @property int|null $organization_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsPossibleDirection whereOrganizationTypeId($value)
 */
class ExpertsPossibleDirection extends Model
{

    protected $table ='possible_directions';

    public function expert()
    {
        $this->belongsTo(Expert::class,'expert_id');
    }
    public function direction()
    {
        return $this->belongsTo(ExpertDirection::class,'direction_id');
    }
    public function spec()
    {
        return $this->belongsTo(ExpertSpec::class,'spec_id');
    }

}
