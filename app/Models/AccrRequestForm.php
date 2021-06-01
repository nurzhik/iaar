<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\AccrRequestFormNode;



/**
 * App\Models\AccrRequestForm
 *
 * @property int $id
 * @property int $type_id
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequestForm whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\AccrRequestFormNode[] $nodes
 */
class AccrRequestForm extends Model
{

    protected $table ='accreditation_request_forms';

    protected $fillable =['type_id'];

    public function updateFix()
    {
        $this->file = str_replace('https://iaar.iaar.agency','',$this->file);
        $this->save();
    }

    public function nodes()
    {
        return $this->hasMany(AccrRequestFormNode::class,'parent_id');
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
