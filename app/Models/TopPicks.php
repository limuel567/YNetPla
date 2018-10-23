<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helper;
use App\Models\Entry;
use App\Models\Configuration;
use Carbon\Carbon;
use Session;
use Crypt, Auth;

class TopPicks extends Model{

    protected $table = 'top_picks';

    public static function createTopPicks($request, $sponsored)
    {
        $data = new self;
        $data->subscription_type = $request->subscription_type; // Free or Trial
        if($request->subscription_period == ''){
            $request->subscription_period = 60;
        }
        $data->subscription_period = $request->subscription_period;
        $data->name = $request->name;
        $data->description = serialize($request->description);
        $data->save();
        return $data;
    }

    public static function updateTopPicks($request, $movie_or_tvshows)
    {
        $data = self::find(Crypt::decrypt($request->id));
        $data->selected = serialize($movie_or_tvshows);
        $data->save();
        return $data;
    }
}