<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

use DB;

class Pages extends Model{

    protected $table = 'pages';

    public static function addData($request)
    {
    	$data       = new self;
        $data->name = $request->page_name;
        $data->save();
        return $data->id;
    }

    public static function getData($id='none')
    {
    	if ($id != 'none') {
    		$data['self_data'] = self::find($id);
    		if (!empty($data['self_data'])) {
    			$data['page_content'] = DB::table('page_section')
    										->join('page_content','page_section.id','=','page_content.section_id')
    										->where('page_content.page_id',$data['self_data']->id)
                                            ->orderBy('page_section.id','asc')
                                            ->orderBy('page_content.created_at','asc')
                                            ->get();
                $data['page_section'] = DB::table('page_section')
    										->join('page_content','page_section.id','=','page_content.section_id')
    										->where('page_content.page_id',$data['self_data']->id)
    										->distinct()
    										->select('page_section.name')
                                            ->orderBy('page_section.id','asc')
                                            ->get();
    		}
    	}
    	return (object) $data;
    }

}