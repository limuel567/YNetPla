<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Session;
use Image;
use File;
use DateTime;

class Helper extends Model{

    public static function generateUUID() {

        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function formatDateTimeOpen($job_date){
        $date = strtotime($job_date);//Converted to a PHP date (a second count)

        //Calculate difference
        $diff = $date - time();//time returns current time in seconds
        $days = floor($diff / (60 * 60 * 24));//seconds/minute*minutes/hour*hours/day)
        $hours = round(($diff - $days * 60 * 60 * 24) / (60 * 60));
        if($days < 1){
            return $hours . " hours to enter";
        }else if($days == 1){
            if($hours == 1){
                return $days . " day to enter";
            }else if($hours < 1){
                return $days . " day to enter";
            }
            return $days . " day to enter";
        }
        else{
            if($hours == 1){
                return $days . " days, to enter";
            }else if($hours < 1){
                return $days . " days to enter";
            }
            return $days . " days to enter";
        }
    }

    public static function formatDateTimeVoting($job_date){
        $date = strtotime($job_date);//Converted to a PHP date (a second count)

        //Calculate difference
        $diff = $date - time();//time returns current time in seconds
        $days = floor($diff / (60 * 60 * 24));//seconds/minute*minutes/hour*hours/day)
        $hours = round(($diff - $days * 60 * 60 * 24) / (60 * 60));
        if($days < 1){
            return "Voting closes in " . $hours . " hours";
        }else if($days == 1){
            if($hours == 1){
                return "Voting closes in " . $days . " day";
            }else if($hours < 1){
                return "Voting closes in " . $days . " day";
            }
            return "Voting closes in " . $days . " day";
        }
        else{
            if($hours == 1){
                return "Voting closes in " . $days . " days";
            }else if($hours < 1){
                return "Voting closes in " . $days . " days";
            }
            return "Voting closes in " . $days . " days";
        }
    }

    public static function formatDateTimeClosed($job_date){
        $date = strtotime($job_date);//Converted to a PHP date (a second count)

        //Calculate difference
        $diff = $date - time();//time returns current time in seconds
        $days = floor($diff / (60 * 60 * 24));//seconds/minute*minutes/hour*hours/day)
        $hours = round(($diff - $days * 60 * 60 * 24) / (60 * 60));
        if($days < 1){
            return "Ended " . $hours . " hours";
        }else if($days == 1){
            if($hours == 1){
                return "Ended " . $days . " day";
            }else if($hours < 1){
                return "Ended " . $days . " day";
            }
            return "Ended " . $days . " day";
        }
        else{
            if($hours == 1){
                return "Ended " . $days . " days";
            }else if($hours < 1){
                return "Ended " . $days . " days";
            }
            return "Ended " . $days . " days";
        }
    }

    public static function convertNumber( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }

    public static function bytesToHuman($bytes)
    {
        $units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            //if($minutes==1){
            //    return "a minute ago";
            //}
            //else{
                return "$minutes".'m';
            //}
        }
        //Hours
        else if($hours <=24){
            //if($hours==1){
            //    return "an hour ago";
            //}else{
                return "$hours".'h';
            //}
        }
        //Days
        else if($days <= 7){
            //if($days==1){
            //    return "yesterday";
            //}else{
                return "$days".'d';
            //}
        }
        //Weeks
        else if($weeks <= 4.3){
            //if($weeks==1){
            //    return "a week ago";
            //}else{
                return "$weeks".'w';
            //}
        }
        //Months
        else if($months <=12){
            //if($months==1){
            //    return "a month ago";
            //}else{
                return "$months".'mo';
            //}
        }
        //Years
        else{
            //if($years==1){
            //    return "a year ago";
            //}else{
                return "$years".'yrs';
            //}
        }
    }

    public static function creditCardType($number)
    {
        if (preg_match('/^3[47][0-9]{13}$/',$number)) {
            return 'amex';
        } elseif(preg_match('/^5[1-5][0-9]{14}$/',$number)) {
            return 'mastercard';
        } elseif(preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number)) {
            return 'visa';
        } elseif(preg_match("/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/", $number)) {
            return "diners_club";            
        } elseif(preg_match("/^6(?:011|5[0-9]{2})[0-9]{12}$/", $number)) {
            return "discover";            
        } elseif(preg_match("/^(?:2131|1800|35\d{3})\d{11}$/", $number)) {
            return "jcb";            
        } else{ return '0'; }
    }

    public static function timeDuration($date)
    {
        $full     = false;
        $now      = new DateTime;
        $ago      = new DateTime($date);
        $diff     = $now->diff($ago);
        $diff->w  = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $date = array(
                        'y' => 'year',
                        'm' => 'month',
                        'w' => 'week',
                        'd' => 'day',
                        'h' => 'hour',
                        'i' => 'minute',
                        's' => 'second',
                    );
        foreach ($date as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($date[$k]);
            }
        }
        if (!$full) $date = array_slice($date, 0, 1);
        $date = ($date ? implode(', ', $date) . ' ago' : 'just now');
        return $date;
    }

    public static function seoUrl($string)
    {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    public static function flashMessage($header,$content,$boolean)
    {
        Session::flash('session_header',$header);
        Session::flash('session_content',$content);
        Session::flash('session_boolean',$boolean);
    }

    public static function destroySession()
    {
        Session::forget('session_header');
    }

    public static function uploadFile($custom_old_file,$custom_file_size,$old_file,$field_name,$request,$first_folder,$second_folder='',$third_folder='',$fourth_folder='')
    {
        $data = [];
        // ----------- Path holder ----------- //
        if ($fourth_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/'.$third_folder.'/'.$fourth_folder.'/';
        } elseif ($third_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/'.$third_folder.'/';
        } elseif ($second_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/';
        } else {
            $path = 'uploads/'.$first_folder.'/';
        }
        $old_file_name = self::pathChecker($old_file);
        // ----------- Upload the file ----------- //
        $file               = $request->file($field_name);
        // Generate new name
        $generated_filename = time()."__".$file->getClientOriginalName();
        // Move the file
        $file_copy          = $file->move(base_path().'/'.$path, $generated_filename);
        file_exists($old_file_name) ? File::delete(base_path().'/'.$old_file_name) : '';
        $data['new_path']   = $path.$generated_filename;
        // ----------- Convert the file ----------- //
        if ($custom_old_file != 'none') {
            $old_file_name = self::pathChecker($custom_old_file);
            file_exists($old_file_name) ? File::delete(base_path().'/'.$old_file_name) : '';
            $custom_path = base_path().'/uploads/custom_size/';
            if (!File::exists($custom_path)) {
                // Create a directory path
                File::makeDirectory($custom_path);
            }
            // Convert the photo
            $path             = '/uploads/custom_size/'.$generated_filename;
            $custom_size_path = base_path().$path;
            Image::make($file_copy,array( // Convert the width and height
                'width'  => $custom_file_size,
                'height' => $custom_file_size
            ))->save($custom_size_path);
            $data['custom_size_path'] = $path;
        } else {
            $data['custom_size_path'] = 'none';
        }
        return $data;
    }

    public static function pathChecker($path)
    {
        if ($path != 'uploads/others/no_image.jpg' && $path != 'uploads/others/no_avatar.jpg' && $path != 'uploads/others/no_video.jpg'){
            return $path;
        } else {
            return NULL;
        }
    }

    public static function deleteFile($old_file,$first_folder,$second_folder='',$third_folder='',$fourth_folder='')
    {
        if ($fourth_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/'.$third_folder.'/'.$fourth_folder.'/';
        } elseif ($third_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/'.$third_folder.'/';
        } elseif ($second_folder != '') {
            $path = 'uploads/'.$first_folder.'/'.$second_folder.'/';
        } else {
            $path = 'uploads/'.$first_folder.'/';
        }
        if ($old_file != 'uploads/others/no_image.jpg' && $old_file != 'uploads/others/no_avatar.jpg' && $old_file != 'uploads/others/no_video.jpg'){
            File::delete(base_path().'/'.$old_file);
            // Check the directory if empty
            if (count(scandir(base_path().'/'.$path)) == 2) {
                // Remove the path
                rmdir(base_path().'/'.$path);
            }
        }
    }

    public static function getYears($number_of_years=0,$include_pass=false)
    {
        $pass = ($include_pass) ? (0 - $number_of_years): 0;
        $arr  = [];
        for($i = $pass; $i < $number_of_years; $i++){ 
            $year    = date("Y", strtotime('+'.$i.' years'));
            $numeric = date("y", strtotime('+'.$i.' years'));
            $data    = (object) array(
                                        'name'    => $year, 
                                        'numeric' => $numeric, 
                                    );
            array_push($arr,$data);
        }
        return $arr;
    }

    public static function getYearsDesc($number_of_years=0,$include_pass=false)
    {
        $pass = ($include_pass) ? ( 0 - $number_of_years ): 0;
        $arr  = [];
        for ($i = $pass; $i < $number_of_years; $i++) { 
            $year    = date("Y", strtotime('-'.$i.' years'));
            $numeric = date("y", strtotime('-'.$i.' years'));
            $data    = (object) array(
                                        'name'    => $year, 
                                        'numeric' => $numeric, 
                                    );
            array_push($arr,$data);
        }
        return $arr;
    }

    public static function getMonths()
    {
        $arr = [];
        for ($i=1; $i < 13; $i++) { 
            $month     = date('F', mktime(0,0,0,$i, 1, date('Y')));
            $shortname = date('M', mktime(0,0,0,$i, 1, date('Y')));
            $data      = (object) array(
                                        'name'      => $month, 
                                        'numeric'   => ($i < 10) ? "0".$i : $i, 
                                        'shortname' => $shortname
                                    );
            array_push($arr,$data);
        }
        return $arr;
    }

    public static function convertObjectsToArray($obj) // To clean the index
    {
        $array = [];
        foreach ($obj as $value) {
            $array[] = $value;
        }
        return $array;
    }

}