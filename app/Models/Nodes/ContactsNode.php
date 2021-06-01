<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\ContactsNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $address
 * @property string|null $site
 * @property string|null $map_code
 * @property string|null $content
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereMapCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ContactsNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactsNode extends Model
{

    protected $table ='contacts_nodes';

}
