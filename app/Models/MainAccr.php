<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nodes\MainAccrNode;
use App\Models\Logs\RegistryUpdatedLog;

/**
 * App\Models\MainAccr
 *
 * @property int $id
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int|null $years
 * @property int|null $university_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereYears($value)
 * @mixin \Eloquent
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereCommitteeConsistDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereDecisionDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereOrgForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereReportDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereUniverTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereVisitDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereVisitDateStart($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\MainAccrNode[] $nodes
 * @property int $reakkr
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MainAccr whereReakkr($value)
 */
class MainAccr extends Model
{
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

    protected $table ='main_accreditations';

    public function univer()
    {
        return $this->belongsTo(Univer::class,'university_id');
    }
    public function nodes()
    {
        return $this->hasMany(MainAccrNode::class,'parent_id');
    }
    public function getLocaleNode($lang)
    {
        $node = $this->nodes()->where('lang',$lang)->first();
        if(!empty($node))
            return $node;
        else
            return $this;
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

}
