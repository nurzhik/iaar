<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\PartnerNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $text
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\PartnerNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PartnerNode extends Model
{

    protected $table ='partners_nodes';

}
