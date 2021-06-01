<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\UniverNode
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\UniverNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UniverNode extends Model
{

    protected $table ='univer_nodes';

}
