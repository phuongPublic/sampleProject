<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StationLines extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'station_lines';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'line_cd';
}
