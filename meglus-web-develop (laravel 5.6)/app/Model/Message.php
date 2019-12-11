<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','applicant_id','from_id','to_id','send_direction','type','content',
        'status','created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    const OPENED = 1;
    const NOT_OPENED = 0;

    /**
     * Get message list by applicant
     *
     * @param $applicant_id
     * @param $demand_user_id
     * @return mixed
     */
    public static function getMessagesListByApplicantId($applicant_id, $demand_user_id) {
        return Message::select('message.id', 'message.from_id', 'message.to_id', 'message.send_direction', 'message.type', 'message.content', 'message.status')
            ->join('applicant', 'applicant.id', 'message.applicant_id')
            ->where('applicant_id', $applicant_id)
            ->where('applicant.demand_user_id', $demand_user_id)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get latest message by applicant
     *
     * @param $applicant_id
     * @param $demand_user_id
     * @return mixed
     */
    public static function getLatestMessageByApplicantId($applicant_id, $demand_user_id) {
        $message = Message::select('message.id', 'message.from_id', 'message.to_id', 'message.send_direction', 'message.type', 'message.content', 'message.status')
            ->join('applicant', 'applicant.id', 'message.applicant_id')
            ->where('applicant_id', $applicant_id)
            ->where('applicant.demand_user_id', $demand_user_id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();

        if (isset($message[0])) {
            $message[0]->status = Message::OPENED;
            $message[0]->save();
        }

        return $message;
    }

    /**
     * Get detail message
     *
     * @param $message_id
     * @param $user_id
     * @return mixed
     */
    public static function getDetailMessageByMessageIdAndUserId($message_id, $user_id) {
        $message = Message::select('message.id', 'message.from_id', 'message.to_id', 'message.send_direction', 'message.type', 'message.content', 'message.status')
            ->join('applicant', 'applicant.id', 'message.applicant_id')
            ->where('applicant.demand_user_id', $user_id)
            ->where('message.id', $message_id)
            ->first();

        if (isset($message)) {
            $message->status = Message::OPENED;
            $message->save();
        }

        return $message;
    }

    /**
     * Get number of unread messages by user id
     *
     * @param $user_id
     * @return mixed
     */
    public static function countNumberOfUnread($user_id) {
        $number = Message::select('message.id')
            ->join('applicant', 'applicant.id', 'message.applicant_id')
            ->where('applicant.demand_user_id', $user_id)
            ->where('message.status', Message::NOT_OPENED)
            ->count();

        return $number;
    }
}
