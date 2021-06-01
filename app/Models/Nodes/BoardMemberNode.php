<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\BoardMemberNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $job
 * @property string|null $content
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $short_desc
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\BoardMemberNode whereShortDesc($value)
 */
class BoardMemberNode extends Model
{

    protected $table ='board_members_nodes';

}
