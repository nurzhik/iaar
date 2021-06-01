<?php

namespace App\Models\Nodes;

use Illuminate\Database\Eloquent\Model;
use App\Models\StaticPage;



/**
 * App\Models\Nodes\StaticPageNode
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $content
 * @property string|null $documents
 * @property string|null $additional_documents
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $og_title
 * @property string|null $og_img
 * @property string|null $og_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereAdditionalDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereOgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nodes\StaticPageNode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\StaticPage|null $parent
 */
class StaticPageNode extends Model
{

    protected $table ='static_pages_nodes';

    public function parent()
    {
        return $this->belongsTo(StaticPage::class,'parent_id');
    }


    public function getDecodedDocuments()
    {
        if(strlen($this->documents) and $this->documents)
            return json_decode($this->documents,true);
        else return [];

    }

    public function getDecodedAddDocuments()
    {
        if(strlen($this->additional_documents) and $this->additional_documents)
            return json_decode($this->additional_documents,true);
        else return [];

    }

    public static function encodeDocuments($data)
    {
        $result = [];
        foreach($data as $key=>$doc)
        {
            $item = [];
            if(!isset($doc['name']) or !isset($doc['file']))
                return false;
            $item['name'] = $doc['name'];
            $item['file'] = str_replace(url('/'),'',$doc['file']);
            $item['id'] = $key;
            $result[] = $item;
        }
        return json_encode($result,true);

    }

}
