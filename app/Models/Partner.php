<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\PartnerNode;



/**
 * App\Models\Partner
 *
 * @property int $id
 * @property int|null $type_id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $logo
 * @property string|null $image
 * @property string|null $text
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $sort_order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereSortOrder($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\PartnerNode[] $nodes
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereLink($value)
 * @property int $is_international
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereIsInternational($value)
 */
class Partner extends Model
{

    protected $table ='partners';

    public function updateFix()
    {
        $this->image = str_replace('https://iaar.iaar.agency','',$this->image);
        $this->logo = str_replace('https://iaar.iaar.agency','',$this->logo);
        $this->save();
    }

    public function nodes()
    {
        return $this->hasMany(PartnerNode::class,'parent_id');
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
