<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\TeamMemberNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $name
 * @property string|null $job
 * @property int|null $sort_order
 * @property string|null $experience
 * @property string|null $education
 * @property string|null $languages
 * @property string|null $qualities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereQualities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\TeamMemberNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamMemberNode extends Model
{

    protected $table ='team_members_nodes';

}
