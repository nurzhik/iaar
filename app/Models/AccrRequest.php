<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\AccrRequest
 *
 * @property int $id
 * @property int $viewed
 * @property string|null $name
 * @property string|null $email
 * @property string|null $message
 * @property string|null $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccrRequest whereViewed($value)
 * @mixin \Eloquent
 */
class AccrRequest extends Model
{

    protected $table ='accreditation_requests';


}
