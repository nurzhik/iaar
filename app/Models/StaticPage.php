<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Nodes\StaticPageNode;
use App\Models\CommisionTab;
use App\Models\CommisionFile;

/**
 * App\Models\StaticPage
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property int|null $type_id
 * @property int|null $sort_order
 * @property string|null $main_image
 * @property string|null $content
 * @property string|null $documents
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BoardMember[] $boardMembers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TeamMember[] $teamMembers
 * @property int|null $appearance_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereAppearanceType($value)
 * @property int|null $univer_type_id
 * @property int|null $country_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereUniverTypeId($value)
 * @property int|null $year
 * @property string|null $additional_documents
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereAdditionalDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StaticPage whereYear($value)
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attachment[] $attachments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\StaticPageNode[] $nodes
 */
class StaticPage extends Model
{


    public function updateFix()
    {
        $this->main_image = str_replace('https://iaar.iaar.agency','',$this->main_image);
        $this->additional_documents = str_replace('https:\/\/iaar.iaar.agency','',$this->additional_documents);
        if($this->additional_documents == '""')
            $this->additional_documents = null;
        $this->documents = str_replace('https:\/\/iaar.iaar.agency','',$this->documents);
        if($this->documents == '""')
            $this->documents = null;

        $this->content = str_replace('https://iaar.iaar.agency','',$this->content);
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->additional_documents = str_replace('https:\/\/iaar.iaar.agency','',$node->additional_documents);
            if($node->additional_documents == '""')
                $node->additional_documents = null;
            $node->documents = str_replace('https:\/\/iaar.iaar.agency','',$node->documents);
            if($node->documents == '""')
                $node->documents = null;
            $node->content = str_replace('https://iaar.iaar.agency','',$node->content);
            $node->save();
        }
    }

    public static function getYearsArray()
    {
        $now = Carbon::now();
        $year = $now->year;
        $ar = [];
        for($i = $year; $i>=2012;$i--)
        {
            $ar[]=$i;
        }
        return $ar;
    }
    public function tabs()
    {
        return $this->hasMany(CommisionTab::class,'page_id');
    }
    public function files()
    {
        return $this->hasMany(CommisionFile::class,'page_id');
    }
    public static function getTypeIdArray()
    {

        return [

            'about_main_page' => 36,

            'organization_structure' => 1,
            'board_members' => 2,
            'team_members' => 3,
            'experts_page' => 4,

            'strategy' => 5,
            'normative' => 6,
            'inner_system' => 7,
            'outer_value' => 8,

            'intern_cooperation_hidden' => 19,
            'intern_networks' => 20,
            'intern_partners' => 21,
            'intern_projects' => 22,
            'intern_events' =>23,
            'intern_event_item' =>24,
            'about_us' => 33,
            'national_partners' => 34,

            'accreditation_page' => 9,

            'rating_page' => 10,
            'rating_council'=>32,
            'rating_static_text' => 35,

            'accreditation_static_text' => 37,

            'naar_year_report' => 11,
            'naar_analytic_report' =>12,

            'journals_archive' => 13,
            'journals_council' =>25,
            'journals_order'=>26,
            'journals_require'=>27,
            'journals_subscription'=>28,
            'journals_about'=>29,


            'naar_publications' =>14,
            'video_archive' =>15,

            'smi' =>16,
            'smi_event' => 30,

            'students' =>17,

            'forum' => 31,

            'postmonitoring' =>18,
        ];
    }

    public static function getRussianName($category)
    {
        $ar =  [
            'organization_structure' => 1,
            'board_members' => 2,
            'team_members' => 3,
            'experts_page' => 4,

            'strategy' => 'Стратегия НААР',

            'normative' => 'Нормативные документы',

            'inner_system' => 'Внутренняя система качества',

            'outer_value' => 'Внешняя оценка качества',
            'students' => 'Студенты',
            'forum' => 'Форум',
            'about_us' => 'О нас',
            'national_partners' => 'Национальные партнеры'
        ];
        if(isset($ar[$category]))
            return $ar[$category];
        else return 'ОШИБКА НЕТ РУССКОГО НАЗВАНИЯ';
    }

    public static function validStaticPagesArray()
    {
        return [5,6,7,8,17,31,33,34];
    }
    protected $table ='static_pages';

    protected $fillable =['type_id','appearance_type'];

    public function getDecodedDocuments()
    {
        if(strlen($this->documents) and $this->documents)
            return json_decode($this->documents,true);
        else return [];

    }

    public function getDecodedAddDocuments()
    {
        if(strlen($this->additional_documents) and $this->additional_documents)
            return json_decode($this->additional_documents,true);
        else return [];

    }

    public static function encodeDocuments($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['name']) or !isset($doc['file']))
                return false;
            $item['name'] = $doc['name'];
            $item['file'] = str_replace(url('/'),'',$doc['file']);
            $item['id'] = $key;
            $result[] = $item;
        }
        return json_encode($result,true);

    }

    public static function encodeAddDocuments($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['name']) or !isset($doc['file']))
                return false;
            $item['name'] = $doc['name'];
            $item['file'] = str_replace(url('/'),'',$doc['file']);
            $item['image_preview'] = str_replace(url('/'),'',$doc['image_preview']);
            $item['id'] = $key;
            $result[] = $item;
        }
        return json_encode($result,true);

    }

    public static function encodeTabs($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['name']) or !isset($doc['content']))
                return false;
            $item['name'] = $doc['name'];
            $item['content'] = $doc['content'];
            $item['id'] = $key;
            $result[]= $item;
        }
        return json_encode($result,true);
    }

    public static function encodePartners($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['name']) or !isset($doc['content']))
                return false;
            $item['name'] = $doc['name'];
            $item['content'] = $doc['content'];
            $item['image_preview'] = str_replace(url('/'),'',$doc['image_preview']);
            $item['id'] = $key;
            $result[]= $item;
        }
        return json_encode($result,true);
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function boardMembers()
    {
        return $this->hasMany(BoardMember::class,'page_id');
    }
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class,'page_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class,'page_id');
    }

    public function nodes()
    {
        return $this->hasMany(StaticPageNode::class,'parent_id');
    }

    public function getLocaleNode($lang)
    {
        $node = $this->nodes()->where('lang',$lang)->first();
        if(!empty($node))
            return $node;
        else
            return $this;
    }

}
