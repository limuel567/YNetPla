<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pages\Pages;
use App\Models\Pages\PageSection;
use App\Models\Pages\PageContent;
use App\Models\Entry;

class GalleryController extends Controller {
   
    function getIndex()
    {
        $data['page'] = Pages::find(2);
        $data['content'] = PageContent::where('page_id', 2)->get();
        $data['entries'] = Entry::where('rank', '<>', NULL)->latest()->get();
        return view('frontend.gallery.index', $data);
    }

}