<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;




/**
 * App\Models\Nodes\MainAccrNode
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
 * @property string|null $org_form
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereCommitteeConsistDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereDecisionDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereOrgForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereReportDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\MainAccrNode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nodes\CountryNode[] $nodes
 */
class MainAccrNode extends Model
{

    protected $table ='main_accrs_nodes';


}
