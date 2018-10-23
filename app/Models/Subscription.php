<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Crypt;

class Subscription extends Model{

    protected $table = 'subscriptions';

    public static function createSubscription($request, $sponsored)
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

    public static function updateSubscription($request)
    {
        $data = self::find(Crypt::decrypt($request->id));
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
}