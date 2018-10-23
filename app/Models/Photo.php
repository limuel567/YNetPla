<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Session;
use Crypt;

class Photo extends Model{

    protected $table = 'photos';

    public static function updatePhoto($request, $id)
    {
        $photo = self::find($id);
        $photo->caption = $request->caption;
        $photo->location = $request->location;
        $photo->tags = $request->keywords;
        $photo->save();

        return $photo;
    }

    public function scopeSearch($query, $s)
    {
        $keys = explode(" ", $s);
        return $query->where('tags', 'like', '%' .$s.'%')
        ->orWhere(function($q) use ($keys){
            foreach($keys as $key){
                $q->Where('tags', 'like', '%' .$key.'%');
            }
        });
    }
}