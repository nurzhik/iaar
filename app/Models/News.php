<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\News
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
 * @property string|null $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereIsEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereMainSlider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ArticleNode[] $nodes
 */
class News extends Article
{

    public static function boot()
    {

        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('is_event', false);
        });
        self::creating(function($model){
            $model->is_event = false;
        });

    }

}
