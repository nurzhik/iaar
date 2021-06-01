<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\CountryNode;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Univer[] $universities
 * @property int $is_registry
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIsRegistry($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StaticPage[] $pages
 * @property int $is_searchable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIsSearchable($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\CountryNode[] $nodes
 * @property int $is_accr
 * @property int $is_rating
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIsAccr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIsRating($value)
 * @property int|null $sort_order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereSortOrder($value)
 */
class Country extends Model
{

    protected $table ='countries';

    public function universities()
    {
        return $this->hasMany(Univer::class,'country_id');
    }
    public function pages()
    {
        return $this->hasMany(StaticPage::class,'country_id');
    }

    public function nodes()
    {
        return $this->hasMany(CountryNode::class,'parent_id');
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
