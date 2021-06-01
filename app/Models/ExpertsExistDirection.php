<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ExpertsExistDirection
 *
 * @property int $id
 * @property int|null $expert_id
 * @property int|null $accr_type
 * @property string|null $organization_title
 * @property string|null $organization_type_id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereAccrType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereExpertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereOrganizationTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereOrganizationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $direction_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereDirectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsExistDirection whereSpecId($value)
 * @property int|null $spec_id
 * @property-read \App\Models\ExpertSpec|null $spec
 * @property-read \App\Models\ExpertDirection|null $direction
 */
class ExpertsExistDirection extends Model
{

    protected $table ='existing_directions';
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
