<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StationNumbers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'station_numbers';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'station_cd';

}
