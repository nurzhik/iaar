<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\ExtReportNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $text
 * @property string|null $lang
 * @property int|null $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ExtReportNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExtReportNode extends Model
{

    protected $table ='external_review_reports_nodes';


    public function getEncodedText()
    {
        if(strlen($this->text) and $this->text)
            return json_decode($this->text,true);
        else return [];
    }

}