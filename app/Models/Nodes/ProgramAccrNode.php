<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Nodes\ProgramAccrNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $license
 * @property string|null $report_doc
 * @property string|null $decision_doc
 * @property string|null $committee_consist_doc
 * @property string|null $program_title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereCommitteeConsistDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereDecisionDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereProgramTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereReportDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $org_form
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\ProgramAccrNode whereOrgForm($value)
 */
class ProgramAccrNode extends Model
{

    protected $table ='program_accr_nodes';

}
