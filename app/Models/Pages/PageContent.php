<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

use App\Models\Pages\PageSection;
use App\Models\Helper;

class PageContent extends Model{

    protected $table = 'page_content';

    public static function getData($id='none',$page_id='none')
    {
        if($page_id != 'none'){
            $sections = PageSection::orderBy('created_at','asc')->get();
            foreach ($sections as $value) {
                // Clean the name
                $name = strtolower(str_replace(" ","_",$value->name));
                // -------- Group the arrays by sections -------- //
                $data['section_'.$name] = self::where('page_id',$page_id)
                                                ->where('section_id',$value->id)
                                                ->orderBy('created_at','asc')
                                                ->get();
            }
        }
        return (object) $data;
    }

    public static function addData($page_id,$request)
    {
    	$data                  = new self;
        $data->page_id         = $page_id;
        $data->section_id      = $request->section;
        $data->field_type      = $request->field_type;
        $data->field_name      = $request->field_name;
        if ($request->field_type == 'image' || $request->field_type == 'file') {
            $data->content = 'uploads/others/no_image.jpg';
        }
        if ($request->field_type == 'repeater') {
            $array = [];
            foreach ($request->repeater_field_type as $key => $value) {
                $array[] =  [
                                'field_type' => $value,
                                'field_name' => $request->repeater_field_name[$key]
                            ];
            }
            $data->repeater_fields = serialize($array);
        }
        $data->save();
    }

    public static function updateData($request)
    {
        $pages = self::where('page_id',$request->id)->get();
        foreach ($pages as $page) {
            $repeater = 'true';
            // Check if there is no field name
            if (is_null($request['field_'.$page->id])) {
                if ($page->field_type == 'repeater') {
                    $array = [];
                    $total = count(unserialize($page->repeater_fields));
                    $rq = $request['field_repeater_'.str_replace('-','',Helper::seoUrl(unserialize($page->repeater_fields)[0]['field_name'])).'_'.$page->id];
                    $id           = 'repeater_total_'.$page->id;
                    $total_fields = $request->$id;
                    $int          = (int)$total_fields; // Convert string to int
                    if (empty($rq)) {
                        $rq = [];
                        for ($i=0; $i < $int; $i++) { 
                            $rq[] = '';
                        }
                    } else if(count($rq) != $int) {
                        $exist = $rq;
                        $rq = [];
                        for ($i=0; $i < $int; $i++) {
                            if (isset($exist[$i])) {
                                $rq[] = $exist[$i];
                            } else {
                                $rq[] = '';
                            }
                        }                        
                    }
                    foreach ($rq as $rk => $rv) {
                        $field_type = unserialize($page->repeater_fields)[0]['field_type'];
                        $field_name = unserialize($page->repeater_fields)[0]['field_name'];
                        if (is_string($rv) || is_numeric($rv) || is_null($rv)) { // Not file or image
                            $field_value = $rv;
                        } else {
                            // Image/File section
                            $data = self::find($page->id);
                            if (!empty($data->content)) {
                                if (array_key_exists(0,unserialize(base64_decode($data->content)))) {
                                    if (!empty(unserialize(base64_decode($data->content))[$rk][0]['field_value'])) {
                                        if (strpos(unserialize(base64_decode($data->content))[$rk][0]['field_value'], 'uploads/cms/') !== false || strpos(unserialize(base64_decode($data->content))[$rk][0]['field_value'], 'uploads/others/no_image.jpg') !== false) {
                                            // Delete file holds old file and first folder
                                            Helper::deleteFile(unserialize(base64_decode($data->content))[$rk][0]['field_value'],'cms');
                                        }                                              
                                    }
                                }
                            }
                            $file = $rv;
                            // Generate new name
                            $generated_filename = time()."__".$file->getClientOriginalName();
                            $file->move(base_path().'/'.'uploads/cms/', $generated_filename);
                            $field_value = 'uploads/cms/'.$generated_filename;
                        }
                        if (empty($field_value)) {
                            $data = self::find($page->id);
                            $field_value = 'uploads/others/no_image.jpg';
                            if (!empty($data->content)) {
                                if (array_key_exists($rk,unserialize(base64_decode($data->content)))) {
                                    if (!empty(unserialize(base64_decode($data->content))[$rk][0]['field_value'])) {
                                        if (strpos(unserialize(base64_decode($data->content))[$rk][0]['field_value'], 'uploads/cms/') !== false || strpos(unserialize(base64_decode($data->content))[$rk][0]['field_value'], 'uploads/others/no_image.jpg') !== false) {
                                            $field_value = unserialize(base64_decode($data->content))[$rk][0]['field_value'];
                                        }                                              
                                    }
                                }
                            }
                        }
                        if ($field_value == 'uploads/others/no_image.jpg') {
                            if ($field_type != 'image' && $field_type != 'file') {
                                $field_value = '';
                            }
                        }
                        $array[] =  [
                                        0 =>    [
                                                    'field_type'  => $field_type,
                                                    'field_name'  => $field_name,
                                                    'field_value' => $field_value
                                                ]
                                    ];
                        for ($i=1; $i < $total; $i++) {
                            $rq           = $request['field_repeater_'.str_replace('-','',Helper::seoUrl(unserialize($page->repeater_fields)[$i]['field_name'])).'_'.$page->id];
                            $id           = 'repeater_total_'.$page->id;
                            $total_fields = $request->$id;
                            $int          = (int)$total_fields; // Convert string to int
                            if (empty($rq)) {
                                $rq = [];
                                for ($i_inner=0; $i_inner < $int; $i_inner++) { 
                                    $rq[] = '';
                                }
                            } else if(count($rq) != $int) {
                                $exist = $rq;
                                $rq = [];
                                for ($i_inner=0; $i_inner < $int; $i_inner++) {
                                    if (isset($exist[$i_inner])) {
                                        $rq[] = $exist[$i_inner];
                                    } else {
                                        $rq[] = '';
                                    }
                                }                        
                            }
                            $field_type = unserialize($page->repeater_fields)[$i]['field_type'];
                            $field_name = unserialize($page->repeater_fields)[$i]['field_name'];
                            if (is_string($rq[$rk]) || is_numeric($rq[$rk]) || is_null($rq[$rk])) { // Not file or image
                                $field_value = $rq[$rk];  
                            } else {
                                // Image/File section
                                $data = self::find($page->id);
                                if (!empty($data->content)) {
                                    if (array_key_exists($i,unserialize(base64_decode($data->content)))) {
                                        if (!empty(unserialize(base64_decode($data->content))[$i][$rk]['field_value'])) {
                                            if (strpos(unserialize(base64_decode($data->content))[$i][$rk]['field_value'], 'uploads/cms/') !== false || strpos(unserialize(base64_decode($data->content))[$i][$rk]['field_value'], 'uploads/others/no_image.jpg') !== false) {
                                                // Delete file holds old file and first folder
                                                Helper::deleteFile(unserialize(base64_decode($data->content))[$rk][$i]['field_value'],'cms');
                                            }                                                 
                                        }
                                    }
                                }
                                $file = $rq[$rk];
                                // Generate new name
                                $generated_filename = time()."__".$file->getClientOriginalName();
                                $file->move(base_path().'/'.'uploads/cms/', $generated_filename);
                                $field_value = 'uploads/cms/'.$generated_filename;
                            }
                            if (empty($field_value)) {
                                $data = self::find($page->id);
                                $field_value = 'uploads/others/no_image.jpg';
                                if (!empty($data->content)) {
                                    if (array_key_exists($i,unserialize(base64_decode($data->content)))) {
                                        if (!empty(unserialize(base64_decode($data->content))[$rk][$i]['field_value'])) {
                                            if (strpos(unserialize(base64_decode($data->content))[$rk][$i]['field_value'], 'uploads/cms/') !== false || strpos(unserialize(base64_decode($data->content))[$rk][$i]['field_value'], 'uploads/others/no_image.jpg') !== false) {
                                                $field_value = unserialize(base64_decode($data->content))[$rk][$i]['field_value'];
                                            }                                                 
                                        }
                                    }
                                }
                            }
                            if ($field_value == 'uploads/others/no_image.jpg') {
                                if ($field_type != 'image' && $field_type != 'file') {
                                    $field_value = '';
                                }
                            }
                            $array[$rk][] = [
                                                'field_type'  => $field_type,
                                                'field_name'  => $field_name,
                                                'field_value' => $field_value
                                            ];
                        }
                    }
                    $data = self::find($page->id);
                    $data->content = base64_encode(serialize($array));
                    $data->save();
                } else { $repeater = 'false'; }
            } else { $repeater = 'false'; }
            if ($repeater == 'false') {
                if ($page->field_type == 'image' || $page->field_type == 'file') {
                    // Check if the file exist
                    if (!empty($request['field_'.$page->id])) {
                        $data          = self::find($page->id);
                        $field_name    = 'field_'.$page->id;
                        // Upload files holds custom old file, custom file size, old file, field name, request and first folder
                        $path = Helper::uploadFile('none','none',$data->content,$field_name,$request,'cms');
                        $data->content = $path['new_path'];
                        $data->save();
                    }
                } else {
                    $data          = self::find($page->id);
                    $data->content = $request['field_'.$page->id];
                    $data->save();
                }  
            }
        }
    }

    public static function deleteRepeater($request)
    {
        $data = self::find($request->id);
        $array = [];
        foreach (unserialize(base64_decode($data->content)) as $key => $value) {
            if ($key != $request->key) {
                $array[] = $value;
            } else {
                foreach ($value as $v) {
                    if ($v['field_type'] == 'image' || $v['field_type'] == 'file') {
                        // Delete file holds old file and first folder
                        Helper::deleteFile($v['field_value'],'cms');
                    }
                }
            }
        }
        $data->content = count($array) == 0 ? '' : base64_encode(serialize($array));
        $data->save();
    }

}