<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;
use App\Models\AccrRequestForm;



/**
 * App\Models\Nodes\AccrRequestFormNode
 *
 * @property int $id
 * @property string|null $lang
 * @property string|null $file
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\AccrRequestFormNode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AccrRequestForm $parent
 */
class AccrRequestFormNode extends Model
{

    protected $table ='accreditation_requests_forms_nodes';

    public function parent()
    {
        return $this->belongsTo(AccrRequestForm::class,'parent_id');
    }

}
