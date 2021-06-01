<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\AcceptancePartner
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\PartnerNode[] $nodes
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereLink($value)
 * @property int $is_international
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AcceptancePartner whereIsInternational($value)
 */
class AcceptancePartner extends Partner
{

    public static function boot()
    {

        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->where('type_id', 1);
        });
        self::creating(function($model){
            $model->type_id = 1;
        });

    }

}
