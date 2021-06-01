<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\AttachmentNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $short_desc
 * @property string|null $image
 * @property string|null $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AttachmentNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommisionFileNode extends Model
{

    protected $table ='commision_files_nodes';


}
