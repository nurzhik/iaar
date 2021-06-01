<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\ProgramAccrNode;
use App\Models\Logs\RegistryUpdatedLog;

/**
 * App\Models\ProgramAccr
 *
 * @property int $id
 * @property string|null $program_title
 * @property string|null $program_index
 * @property string|null $date_start
 * @property int|null $years
 * @property string|null $date_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $university_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereProgramIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereProgramTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereYears($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExtReport[] $reports
 * @property-read \App\Models\Univer|null $univer
 * @property int|null $univer_type_id
 * @property string|null $registration_number
 * @property string|null $visit_date_start
 * @property string|null $visit_date_end
 * @property string|null $bin
 * @property string|null $license
 * @property string|null $report_doc
 * @property string|null $decision_doc
 * @property string|null $committee_consist_doc
 * @property string|null $org_form
 * @property int $reaccr
 * @property int $ex_ante
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereCommitteeConsistDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereDecisionDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereExAnte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereOrgForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereReaccr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereReportDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereUniverTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereVisitDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereVisitDateStart($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\ProgramAccrNode[] $nodes
 * @property int|null $hidden_relation_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProgramAccr whereHiddenRelationId($value)
 */
class ProgramAccr extends Model
{

    protected $table ='program_accreditations';


    public function updateFix()
    {
        $this->report_doc = str_replace('https://iaar.iaar.agency','',$this->report_doc);
        $this->decision_doc = str_replace('https://iaar.iaar.agency','',$this->decision_doc);
        $this->committee_consist_doc = str_replace('https://iaar.iaar.agency','',$this->committee_consist_doc);
        $this->save();
        foreach($this->nodes()->get() as $node)
        {
            $node->report_doc = str_replace('https://iaar.iaar.agency','',$node->report_doc);
            $node->decision_doc = str_replace('https://iaar.iaar.agency','',$node->decision_doc);
            $node->committee_consist_doc = str_replace('https://iaar.iaar.agency','',$node->committee_consist_doc);
            $node->save();
        }
    }

    public function univer()
    {
        return $this->belongsTo(Univer::class,'university_id');
    }
    public function reports()
    {
        return $this->belongsToMany(ExtReport::class,'ext_program','program_id','ext_report_id');
    }
    public function nodes()
    {
        return $this->hasMany(ProgramAccrNode::class,'parent_id');
    }
    public function getLocaleNode($lang)
    {
        $node = $this->nodes()->where('lang',$lang)->first();
        if(!empty($node))
            return $node;
        else
            return $this;
    }
    public function sameUniverPrograms()
    {
        return  ProgramAccr::where('university_id',$this->university_id)->where('id','<>',$this->id);
    }
    public function joinHiddenRelation(ProgramAccr $brother)
    {
        if(isset($this->hidden_relation_id))
            $this->breakHiddenRelation();
        if($brother->university_id != $this->university_id)
            return false;
        if(isset($brother->hidden_relation_id))
        {
            $this->hidden_relation_id = $brother->hidden_relation_id;
            $this->save();
            return true;
        }
        $max = ProgramAccrNode::where('id','>',0)->max('hidden_relation_id');
        $max++;
        $this->hidden_relation_id = $max;
        $this->save();
        $brother->hidden_relation_id = $max;
        $brother->save();
        return true;

    }
    public function breakHiddenRelation()
    {
        if(isset($this->hidden_relation_id))
        {
            $count = $this->samePrograms()
                ->where('university_id',$this->university_id)->count();
            if($count<3)
            {
                $brothers = $this->samePrograms()->get();
                foreach($brothers as $brother)
                {
                    $brother->hidden_relation_id = null;
                    $brother->save();
                }
            }
            $this->hidden_relation_id = null;
            $this->save();
        }
        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
            if(!empty($log))
            {
                $log->date =  \Carbon\Carbon::now()->format('Y-m-d');
                $log->save();
            }
        });
        static::updating(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
            if(!empty($log))
            {
                $log->date = \Carbon\Carbon::now()->format('Y-m-d');
                $log->save();
            }
        });
        static::deleting(function (Model $model) {
            $log  = RegistryUpdatedLog::where('is_blocked','<>',false)->first();
            if(!empty($log))
            {
                $log->date =  \Carbon\Carbon::now()->format('Y-m-d');
                $log->save();
            }
        });
    }

    public function samePrograms()
    {
        if(strlen($this->hidden_relation_id))
            return ProgramAccr::where('hidden_relation_id',$this->hidden_relation_id)->where('id','<>',$this->id)->where('university_id',$this->university_id);
        else
            return ProgramAccr::where('id','<',0);
    }
}
