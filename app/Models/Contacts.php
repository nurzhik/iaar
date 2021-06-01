<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\ContactsNode;



/**
 * App\Models\Contacts
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $type_id
 * @property string|null $address
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $map_code
 * @property string|null $site
 * @property string|null $fb_link
 * @property string|null $youtube_link
 * @property string|null $content
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereFbLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereMapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts whereYoutubeLink($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ContactsNode[] $nodes
 */
class Contacts extends Model
{

    protected $table ='contacts';

    public function nodes()
    {
        return $this->hasMany(ContactsNode::class,'parent_id');
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
