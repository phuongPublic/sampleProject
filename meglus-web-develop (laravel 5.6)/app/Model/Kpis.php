<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kpis extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kpis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item','calculation_date','volume',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * @param $items
     * @param null $start
     * @param null $end
     * @param string $dateFormat
     * @return mixed
     */
    public static function getKpisByItem($items, $start = null, $end = null, $dateFormat = 'Y/m/d'){
        $model = self::select(
            'item','calculation_date','volume'
        )->whereBetween('calculation_date', [$start, $end]);
        if(is_string($items))
            $model->where('item', $items);
        if(is_array($items))
            $model->whereIn('item', $items);

        $result = $model->get()->reduce(function ($carry, $item) use ($dateFormat){
            $carry[$item->item][date($dateFormat,strtotime($item->calculation_date))] =  $item->volume;

            return $carry;
        },[]);
        return $result;
    }
}
