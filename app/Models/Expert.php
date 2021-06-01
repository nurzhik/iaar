<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Expert
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $type_id не требуется(зависит от направлений)
 * @property int|null $country_id
 * @property int|null $category_id
 * @property string|null $certificate_number
 * @property string|null $certificate_date
 * @property string|null $place_of_work
 * @property string|null $position
 * @property string|null $academic_degrees
 * @property string|null $languages
 * @property string|null $contacts
 * @property int|null $category_number
 * @property int $is_chairman
 * @property int $is_participated
 * @property int|null $foreign_expert_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereAcademicDegrees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCategoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCertificateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCertificateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereForeignExpertType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereIsChairman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereIsParticipated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert wherePlaceOfWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $photo
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expert wherePhoto($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsExistDirection[] $existDirections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpertsPossibleDirection[] $possibleDirections
 */
class Expert extends Model
{

    protected $table ='experts';


    public function updateFix()
    {
        $this->photo = str_replace('https://iaar.iaar.agency','',$this->photo);
        $this->save();

    }

    public static function availableCategoryId()
    {
        return [
            'Зарубежный эксперт' => 0,
            'Национальный эксперт' => 1,
            'Работодатель' => 2,
            'Студент' => 3,
        ];
    }
    public static function availableForeignExpertType()
    {
        return [
            'Рекомендован партнером' => 0,
            'Перешел из базы НАЦ МОН РК' => 1,
            'Прошел обучение на семинаре НААР' => 3,
        ];
    }
    public function existDirections()
    {
        return $this->hasMany(ExpertsExistDirection::class,'expert_id');
    }
    public function possibleDirections()
    {
        return $this->hasMany(ExpertsPossibleDirection::class,'expert_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

}
