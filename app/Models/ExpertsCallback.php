<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExpertsCallback
 *
 * @property int $id
 * @property string|null $surname
 * @property string|null $name
 * @property string|null $third_name
 * @property string|null $address
 * @property string|null $languages
 * @property string|null $level_of_knowing
 * @property string|null $science_degree
 * @property string|null $science_rank
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $work_place
 * @property string|null $job
 * @property string|null $teaching_experience
 * @property string|null $rewards
 * @property string|null $science_sphere
 * @property string|null $expert_spheres
 * @property string|null $documents
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereExpertSpheres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereLevelOfKnowing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereRewards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereScienceDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereScienceRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereScienceSphere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereTeachingExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereThirdName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereWorkPlace($value)
 * @mixin \Eloquent
 * @property string|null $birth_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpertsCallback whereBirthDate($value)
 */
class ExpertsCallback extends Model
{
    //
    protected $table = 'experts_callbacks';
}
