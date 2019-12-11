<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CommutingTime extends Model
{
    public static function createNewRecord($from, $to, $times) {
        $data = array(
            array('from'=> $from, 'to' => $to, 'times' => $times),
            array('from'=> $to, 'to' => $from, 'times' => $times)
        );

        return CommutingTime::insert($data);
    }
}
