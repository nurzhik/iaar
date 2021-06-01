<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\MainPartner
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
 * @property int|null $sort_order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\PartnerNode[] $nodes
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereLink($value)
 * @property int $is_international
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainPartner whereIsInternational($value)
 */
class MainPartner extends Partner
{

    public static function boot()
    {

        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('type_id', 0);
        });
        self::creating(function($model){
            $model->type_id = 0;
        });

    }


}
