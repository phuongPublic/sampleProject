<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostCodeMst extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_code_mst';

    /**
     * get all prefecture
     *
     * @return object
     */
    static function getPrefecture()
    {
        return PostCodeMst::select('prefecture')->distinct('prefecture')->get();
    }
}
