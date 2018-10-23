<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Session;
use Crypt;
use Auth;

class Notification extends Model{

    protected $table = 'notifications';

    public static function notifyComment($photo_id, $from_user_id, $to_user_id)
    {
        $notification = new self;
        $notification->from_user_id = $from_user_id;
        $notification->to_user_id = $to_user_id;
        $notification->photo_id = $photo_id;
        $notification->type = 'comment';
        $notification->save();
        return $notification;
    }

    public static function notifyFollow($from_user_id, $to_user_id)
    {
        $notification = new self;
        $notification->from_user_id = $from_user_id;
        $notification->to_user_id = $to_user_id;
        $notification->photo_id = null;
        $notification->type = 'follow';
        $notification->save();
        return $notification;
    }

    public static function notifyLove($photo_id, $from_user_id, $to_user_id)
    {
        $notification = new self;
        $notification->from_user_id = $from_user_id;
        $notification->to_user_id = $to_user_id;
        $notification->photo_id = $photo_id;
        $notification->type = 'love';
        $notification->save();
        return $notification;
    }

    public static function notifyVote($photo_id, $from_user_id, $to_user_id, $challenge_id)
    {
        $notification = new self;
        $notification->from_user_id = $from_user_id;
        $notification->to_user_id = $to_user_id;
        $notification->photo_id = $photo_id;
        $notification->challenge_id = $challenge_id;
        $notification->type = 'vote';
        $notification->save();
        return $notification;
    }
}