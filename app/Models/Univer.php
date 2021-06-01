<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\UniverNode;
use App\Models\Logs\RegistryUpdatedLog;

/**
 * App\Models\Univer
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $unique_index
 * @property string|null $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $country_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereUniqueIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Univer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExtReport[] $extReports
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MainAccr[] $mainAccrs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProgramAccr[] $programAccrs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\UniverNode[] $nodes
 */
class Univer extends Model
{

    public static function availableTypeIdArray($lang = null)
    {
        if($lang == 'kz')
        {
            return [
                'Жоғары және жоғары оқу орнынан кейінгі білім беру ұйымы'=> 0,
                'Медициналық жоғары және жоғары оқу орнынан кейінгі білім беру ұйымы' => 1,
                'Техникалық және кәсіптік білім беру ұйымы' => 2,
                'Медициналық техникалық және кәсіптік білім беру ұйымы' => 3,
                'Орта білім беру ұйымы (халықаралық мектеп)' => 4,
                'Қосымша білім беру ұйымы' => 5,
                'Ғылыми-зерттеу институты' => 6,
            ];
        }
        if($lang == 'en')
        {
            return [
                'Organisation of Higher and Postgraduate Education'=> 0,
                'Medical Organisation of Higher and Postgraduate Education' => 1,
                'Organisation of Technical and Vocational Education' => 2,
                'Medical Organisation of Technical and Vocational Education' => 3,
                'Organisation of Secondary Education (International School)' => 4,
                'Organisation of Continuing Education' => 5,
                'Research Institute' => 6,
            ];

        }
        return [
            'Организация высшего и послевузовского образования'=> 0,
            'Медицинская организация высшего и послевузовского образования' => 1,
            'Организация  технического и профессионального образования' => 2,
            'Медицинская организация технического и профессионального образования' => 3,
            'Организация среднего образования (международные школы)' => 4,
            'Организация дополнительного образования' => 5,
            'НИИ' => 6,
        ];
    }

    public static function educationTypeIdArray($lang = null)
    {
        if($lang == 'kz')
        {
            return [
                'Бакалавриат'=> 0,
                'Бакалавриат'=> 1,
                'Специалитет' => 2,
                'Магистратура ' => 3,
                'PhD' => 4,
                'Аспирантура' => 5,
                'Резидентура/Ординатура' => 6,
                'MBA' => 7,
                'DBA' => 8,
                'Техникалық және кәсіптік білім беру' => 9,
                'Орта білімнен кейінгі білім беру' => 10,
            ];
        }
        if($lang == 'en')
        {
            return [
                'Bachelor'=> 0,
                'Bachelor'=> 1,
                'Specialist' => 2,
                'Master ' => 3,
                'PhD' => 4,
                'Post-graduate' => 5,
                'Residency' => 6,
                'MBA' => 7,
                'DBA' => 8,
                'Technical & Vocational Education' => 9,
                'Post-Secondary Education' => 10,
            ];

        }
        return [
            'Бакалавриат'=> 0,
            'Бакалавриат'=> 1,
            'Специалитет' => 2,
            'Магистратура ' => 3,
            'PhD' => 4,
            'Аспирантура' => 5,
            'Резидентура/Ординатура' => 6,
            'MBA' => 7,
            'DBA' => 8,
            'Техническое и профессиональное образование' => 9,
            'Послесреднее образование' => 10,
           
        ];
    }
    public static function QfIdArray($lang = null)
    {
        if($lang == 'kz')
        {
            return [
                'Қысқа цикл'=> 0,
                '1 цикл'=> 1,
                '2 цикл' => 2,
                '3 цикл' => 3,
                'Басқа' => 4,
            ];
        }
        if($lang == 'en')
        {
            return [
                'Short cycle'=> 0,
                'First cycle'=> 1,
                'Second cycle' => 2,
                'Third cycle' => 3,
                'Other' => 4,
            ];

        }
        return [
            'Короткий цикл'=> 0,
            '1 цикл'=> 1,
            '2 цикл' => 2,
            '3 цикл' => 3,
            'Другое' => 4,
        ];
    }
    public static function NqfIdArray($lang = null)
    {
        if($lang == 'kz')
        {
            return [
                '5'=> 0,
                '6'=> 1,
                '7' => 2,
                '8' => 3,
                '9' => 4,
                'Басқа' => 5,
            ];
        }
        if($lang == 'en')
        {
            return [
                '5'=> 0,
                '6'=> 1,
                '7' => 2,
                '8' => 3,
                '9' => 4,
                'Other' => 5,
            ];

        }
        return [
            '5'=> 0,
            '6'=> 1,
            '7' => 2,
            '8' => 3,
            '9' => 4,
            'Другое' => 5,
        ];
    }
    protected $table ='universities';

    public function mainAccrs()
    {
        return $this->hasMany(MainAccr::class,'university_id');
    }
    public function programAccrs()
    {
        return $this->hasMany(ProgramAccr::class,'university_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function extReports()
    {
        return $this->hasMany(ExtReport::class,'university_id');
    }
    public function nodes()
    {
        return $this->hasMany(UniverNode::class,'parent_id');
    }
    public function getLocaleNode($lang)
    {
        $node = $this->nodes()->where('lang',$lang)->first();
        if(!empty($node))
            return $node;
        else
            return $this;
    }
    public function getLastMainAccr()
    {
        return $this->mainAccrs()->orderBy('date_start','DESC')->first();
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
           if(!empty($log))
           {
               $log->date =  \Carbon\Carbon::now()->format('Y-m-d');
               $log->save();
           }
        });
        static::updating(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
            if(!empty($log))
            {
                $log->date = \Carbon\Carbon::now()->format('Y-m-d');
                $log->save();
            }
        });
        static::deleting(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
            if(!empty($log))
            {
                $log->date =  \Carbon\Carbon::now()->format('Y-m-d');
                $log->save();
            }
        });
    }

}
