<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DemandUserWorkDay extends Model
{
    //use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demand_user_work_days';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'demand_user_id','day',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function insertNew($demand_user_id, Array $days) {
        DB::table('demand_user_work_days')->where('demand_user_id', $demand_user_id)->delete();

        foreach ($days as $value) {
            $object = new DemandUserWorkDay();
            $object->demand_user_id = $demand_user_id;
            $object->day = $value;
            $object->save();
        }

        return true;
    }

    public static function inserts($did, Array $days) {
        self::where('demand_user_id',$did)->delete();
        foreach ($days as $key => $item)
        {
            $charges[] = [
                'demand_user_id' => $did,
                'day' => $item
            ];
        }
        return self::insert($charges);
    }

}
