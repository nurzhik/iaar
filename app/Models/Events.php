<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Events
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereIsEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereMainSlider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Events whereText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ArticleNode[] $nodes
 */
class Events extends Article
{



    public static function boot()
    {

        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('is_event', true);
        });
        self::creating(function($model){
            $model->is_event = true;
        });

    }

}
