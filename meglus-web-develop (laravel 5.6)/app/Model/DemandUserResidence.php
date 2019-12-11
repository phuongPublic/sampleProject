<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DemandUserResidence extends Model
{
    //use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demand_user_residences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'demand_user_id','qualification','seq',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function insertNew($demand_user_id, Array $qualification) {
        DB::table('demand_user_residences')->where('demand_user_id', $demand_user_id)->delete();

        foreach ($qualification as $key => $value) {
            $object = new DemandUserResidence();
            $object->demand_user_id = $demand_user_id;
            $object->qualification = $value;
            $object->seq = ($key + 1);
            $object->save();
        }

        return true;
    }

    public static function inserts($did, Array $qualification) {
        self::where('demand_user_id',$did)->delete();
        foreach ($qualification as $key => $item)
        {
            $charges[] = [
                'demand_user_id' => $did,
                'qualification' => $item,
                'seq' => ($key + 1)
            ];
        }
        return self::insert($charges);
    }
}
