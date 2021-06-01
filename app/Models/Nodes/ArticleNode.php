<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\ArticleNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $short_desc
 * @property string|null $text
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ArticleNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleNode extends Model
{

    protected $table ='articles_nodes';

}
