<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helper;
use App\Models\Entry;
use App\Models\Configuration;
use Carbon\Carbon;
use Session;
use Crypt, Auth;

class SeasonPremieres extends Model{

    protected $table = 'season_premieres';

    public static function createSeasonPremieres($request)
    {
        $data = new self;
        $data->id = Crypt::decrypt($request->selected);
        $data->name = $request->name;
        $data->premiere_date = $request->premiere_date;
        $data->encoded_json = $request->encoded_json;
        $data->save();
        return $data;
    }

    public static function deleteSeasonPremieres($request, $id)
    {
        $data = self::find($id);
        $data->delete();
        return $data;
    }
}