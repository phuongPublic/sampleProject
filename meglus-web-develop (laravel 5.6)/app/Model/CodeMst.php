<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeMst extends Model
{
    use SoftDeletes;
    //TODO
    const LIST_GROUP = ['important_thing'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'code_mst';

    protected $primaryKey = ['group', 'value'];
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group', 'value', 'label', 'seq'
    ];

    public static function getInfoGroup($group, $lang) {
        if ($lang == 'jp')
            $groupName = $group;
        else
            $groupName = $group . '_' . $lang;

        return CodeMst::where('group', '=', $groupName)
            ->orderBy('seq', 'asc')
            ->get();
    }
}
