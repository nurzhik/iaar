<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\CountryNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\CountryNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CountryNode extends Model
{

    protected $table ='countries_nodes';

}
