<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\MainSliderNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $short_desc
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainSliderNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MainSliderNode extends Model
{

    protected $table ='main_sliders_nodes';

}
