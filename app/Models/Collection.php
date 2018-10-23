<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Session;
use Crypt;

class Collection extends Model{

    protected $table = 'collections';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}