<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\TeamMemberNode;

/**
 * App\Models\TeamMember
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $job
 * @property string|null $photo
 * @property int|null $sort_order
 * @property string|null $experience
 * @property string|null $education
 * @property string|null $languages
 * @property string|null $qualities
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $skype
 * @property int|null $page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereQualities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TeamMember whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\StaticPage|null $page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\TeamMemberNode[] $nodes
 */
class TeamMember extends Model
{

    protected $table ='team_members';


    public function updateFix()
    {
        $this->photo = str_replace('https://iaar.iaar.agency','',$this->photo);
        $this->save();

    }

    public function page()
    {
        return $this->belongsTo(StaticPage::class,'page_id');
    }
    public function nodes()
    {
        return $this->hasMany(TeamMemberNode::class,'parent_id');
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
