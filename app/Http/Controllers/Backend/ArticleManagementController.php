<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Validators;
use Carbon\Carbon;
use Crypt, Session;

class ArticleManagementController extends Controller {
    
    function __construct(){
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }

    function getIndex()
    {   
        $data['segment'] = $this->segment;
        $data['article'] = Article::get();
        return view('backend.article-management.index', $data);
    }

    function getCreate()
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Add';
        return view('backend.article-management.create', $data);
    }

    function getEdit(Request $request,$id)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        $data['article'] = Article::find(Crypt::decrypt($id));
        return view('backend.article-management.create', $data);
    }

    function getDelete(Request $request,$id)
    {
        $delete = Article::find(Crypt::decrypt($id));
        $delete->delete();
        return back();
    }

    function getUpdate($id)
    {
        $data['challenge'] = Challenge::find(Crypt::decrypt($id));
        if (!empty($data['challenge'])) {
            $data['segment'] = $this->segment;
            $data['label'] = 'Edit';
            return view('backend.article-management.create', $data);
        } return back();
    }

    function postCreate(Request $request)
    {
        $validator = Validators::backendValidate($request, "create_article");
        // Check the validator if there's no error
        if ($validator === true) {
            if($request->id){
                dd($request->id);
                Article::updateArticle($request);
            }else{
                Article::createArticle($request);
            }
            return response()->json(["result" => "success"]);
        }
        return response()->json(["result" => "failed", "errors" => $validator->errors()->messages()]);
    }
}