<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\AttachmentNode;


/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $page_id
 * @property string|null $title
 * @property string|null $show_date
 * @property int|null $sort_order
 * @property int|null $year
 * @property string|null $short_desc
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereShortDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereShowDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereYear($value)
 * @mixin \Eloquent
 * @property string|null $file
 * @property-read \App\Models\StaticPage|null $parentPage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attachment whereFile($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\AttachmentNode[] $nodes
 */
class Attachment extends Model
{

    protected $table ='attachments';

    public function updateFix()
    {
        $this->image = str_replace('https://iaar.iaar.agency','',$this->image);
        $this->file = str_replace('https://iaar.iaar.agency','',$this->file);
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->image = str_replace('https://iaar.iaar.agency','',$node->image);
            $node->file = str_replace('https://iaar.iaar.agency','',$node->file);
            $node->save();
        }
    }

    public function parentPage()
    {
        return $this->belongsTo(StaticPage::class,'page_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class,'article_id');
    }

    public function nodes()
    {
        return $this->hasMany(AttachmentNode::class,'parent_id');
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
