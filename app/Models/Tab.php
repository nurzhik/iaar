<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\TabNode;
use App\Models\Tab;
use App\Models\File;
/**
 * App\Models\Article
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $short_desc
 * @property int|null $sort_order
 * @property int $main_slider
 * @property string|null $main_image
 * @property int|null $is_event
 * @property string|null $images
 * @property int $published
 * @property string|null $published_at
 * @property string|null $event_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereIsEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereMainSlider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ArticleNode[] $nodes
 */
class Tab extends Model
{

    protected $table ='tabs';

    public function updateFix()
    {
       
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->text = str_replace('https://iaar.iaar.agency','',$node->text);
            $node->save();
        }
    }
   

    public function nodes()
    {
        return $this->hasMany(TabNode::class,'parent_id');
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
