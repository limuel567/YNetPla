<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Crypt;

class TopPicksData extends Model{

    protected $table = 'top_picks_data';

    public static function addData($request)
    {
        $array = [];
        $data = new self;
        $top_picks_id = Crypt::decrypt($request->id);
        $data->top_picks_id = $top_picks_id;
        if($top_picks_id == 1){
            $data->movie_id = $request->data->getId();
            $date = get_object_vars($request->data->getReleaseDate())['date'];
            $array[] = $request->data->getId();
            $array[] = $request->data->getTitle();
            $array[] = $request->data->getPosterImage();
            $array[] = $date;
            $data->data = serialize($array);
        }else{
            $data->tvshow_id = $request->data[0]->id;
            $date = $request->data[0]->premiered;
            $array[] = $request->data[0]->id;
            $array[] = $request->data[0]->name;
            $array[] = $request->data[0]->images['medium'];
            $array[] = $date;
            $data->data = serialize($array);
        }
        $data->save();
        return $data;
    }

}