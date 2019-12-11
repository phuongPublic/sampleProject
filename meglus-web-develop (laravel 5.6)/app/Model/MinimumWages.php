<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MinimumWages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'minimum_wages';

    /**
     * The primary key for the model.
     *
     * @var string
     */

    protected $primaryKey = 'pref_cd';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pref_cd','amount','issue_at','created_id','updated_id','created_at','updated_at','del_flg','deleted_at'
    ];


    /**
     * Function get all
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll()
    {
        return MinimumWages::select('*')->where('del_flg',0)->orderBy('pref_cd')->get()->toArray();
    }

    /**
     * Function get all
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getMinimumWagesPrefecture()
    {
        return MinimumWages::select(['pref_cd','amount'])->where('del_flg',0)->orderBy('pref_cd')->get();
    }


}
