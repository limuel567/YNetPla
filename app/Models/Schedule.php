<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model{

    protected $table = 'schedule';

    public static function createSchedule($request, $featured, $date)
    {
        $data = new self;
        $data->data = json_encode($request);
        $data->featured = json_encode($featured);
        $data->date = $date;
        $data->save();
        return $data;
    }

    public static function updateSchedule($request, $featured, $date)
    {
        $data = self::find(1);
        $data->data = json_encode($request);
        $data->featured = json_encode($featured);
        $data->date = $date;
        $data->save();
        return $data;
    }
}