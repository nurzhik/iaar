<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\MainSliderNode;



/**
 * App\Models\MainSlider
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $short_desc
 * @property string|null $show_date
 * @property string|null $image
 * @property int|null $sort_order
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereShowDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainSlider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\MainSliderNode[] $nodes
 */
class MainSlider extends Model
{



    protected $table ='main_sliders';

    public function updateFix()
    {
        $this->image = str_replace('https://iaar.iaar.agency','',$this->image);
        $this->save();
    }

    public function nodes()
    {
        return $this->hasMany(MainSliderNode::class,'parent_id');
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
