<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentLogs extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id','key','before','after','other_info',
        'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    public static function logContent($data){
        return self::create($data);
    }

    public static function getSequenceHistory($content_id) {
        return ContentLogs::where('content_id', $content_id)->where('key', 'applicant')->get();
    }
}
