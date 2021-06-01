<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\BoardMemberNode;


/**
 * App\Models\BoardMember
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $job
 * @property string|null $photo
 * @property string|null $content
 * @property int|null $sort_order
 * @property int|null $page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\StaticPage|null $page
 * @property string|null $short_desc
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\BoardMemberNode[] $nodes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardMember whereShortDesc($value)
 */
class BoardMember extends Model
{

    public function updateFix()
    {
        $this->photo = str_replace('https://iaar.iaar.agency','',$this->photo);
        $this->content = str_replace('https://iaar.iaar.agency','',$this->content);
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->content = str_replace(url('https://iaar.iaar.agency '),'',$node->content);
            $node->save();
        }
    }

    protected $table ='board_members';

    public function page()
    {
        return $this->belongsTo(StaticPage::class,'page_id');
    }
    public function nodes()
    {
        return $this->hasMany(BoardMemberNode::class,'parent_id');
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
