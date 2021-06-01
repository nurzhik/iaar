<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\ExtReportNode;

/**
 * App\Models\ExtReport
 *
 * @property int $id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string|null $report_file
 * @property string|null $decision_file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $university_id
 * @property int|null $program_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereDecisionFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereReportFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProgramAccr[] $programs
 * @property-read \App\Models\Univer|null $univer
 * @property string|null $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereText($value)
 * @property int|null $univer_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExtReport whereUniverTypeId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ExtReportNode[] $nodes
 */
class ExtReport extends Model
{
    public function updateFix()
    {
        $this->text = str_replace('https:\/\/iaar.iaar.agency','',$this->text);
        $this->report_file = str_replace('https://iaar.iaar.agency','',$this->report_file);
        $this->decision_file = str_replace('https://iaar.iaar.agency','',$this->decision_file);
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->text = str_replace('https:\/\/iaar.iaar.agency','',$node->text);
            $node->save();
        }
    }

    protected $table ='external_review_reports';
    public function univer()
    {
        return $this->belongsTo(Univer::class,'university_id');
    }
    public static function encodeText($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['content']) or !isset($doc['file']))
                return false;
            $item['content'] =  str_replace(url('/'),'',$doc['content']);
            $item['file'] = str_replace(url('/'),'',$doc['file']);
            $item['decision'] = str_replace(url('/'),'',$doc['decision']);
            $item['filename'] = str_replace(url('/'),'',$doc['filename']);
            $item['decisionname'] = str_replace(url('/'),'',$doc['decisionname']);
            $item['newfile'] = str_replace(url('/'),'',$doc['newfile']);
            $item['newfilename'] = str_replace(url('/'),'',$doc['newfilename']);
            $item['id'] = $key;
            $result[] = $item;
        }
       
        return json_encode($result,true);
    }
    public function getEncodedText()
    {
        if(strlen($this->text) and $this->text)
            return json_decode($this->text,true);
        else return [];
    }
    public function programs()
    {
        return $this->belongsToMany(ProgramAccr::class,'ext_program','ext_report_id','program_id');
    }

    public function nodes()
    {
        return $this->hasMany(ExtReportNode::class,'parent_id');
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
