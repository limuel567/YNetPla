<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Photo;
use App\Models\Entry;
use App\Models\Notification;
use App\Models\Vote;
use Auth, Crypt;

class ChallengesController extends Controller {
   
    function getIndex()
    {
        $data['open'] = Challenge::where('status', 0)->latest()->get();
        return view('frontend.challenges.index', $data);
    }

    function getVoting()
    {
        $data['voting'] = Challenge::where('status', 1)->orderBy('ends_at', 'desc')->get();
        return view('frontend.challenges.voting', $data);
    }

    function getClosed()
    {
        $data['closed'] = Challenge::where('status', 2)->orderBy('ends_at', 'desc')->get();
        return view('frontend.challenges.closed', $data);
    }

    function getView($slug)
    {
        $data['challenge'] = Challenge::where('slug', $slug)->first();
        if($data['challenge']){
            if($data['challenge']->status == 1 || $data['challenge']->status == 2){
                $data['entries'] = Entry::where('challenge_id', $data['challenge']->id)->orderBy('vote_count', 'desc')->get();
            }else{
                $data['entries'] = Entry::where('challenge_id', $data['challenge']->id)->orderBy('created_at', 'asc')->get();
            }
            return view('frontend.challenges.inner', $data);
        }return view('errors.404', $data);
    }

    function getEnter($slug)
    {
        if(Auth::check()){
            $data['challenge'] = Challenge::where('slug', $slug)->first();
            if($data['challenge']){
                if($data['challenge']->status == 0){
                    $exist = Entry::where('challenge_id', $data['challenge']->id)->where('user_id', Auth::user()->id)->first();
                    if(!$exist){
                        $data['photos'] = Photo::where('user_id', Auth::user()->id)->get();
                        return view('frontend.challenges.enter', $data);
                    }return back();
                }
            }return view('errors.404', $data);
        }return back();
    }

    function getRemoveEntry(Request $request, $slug)
    {
        $challenge = Challenge::where('slug', $slug)->first();
        if($challenge){
            if($challenge->status == 0){
                $exist = Entry::find(Crypt::decrypt($request->id));
                if($exist){
                    $entry = $exist->id;
                    $exist->delete();
                    $challenge->submission_count =  $challenge->submission_count - 1;
                    $challenge->save();
                    $total = Entry::where('challenge_id', $challenge->id)->count();
                    $data['slug'] = $challenge->slug;
                    $html = view('frontend.challenges.appends.submit', $data)->render();
                    return response()->json(["result" => "success", "html" => $html, 'total' => $total, 'entry' => $entry]);
                }
            }
        }
    }

    function getOpenChallenges()
    {
        $data['open'] = Challenge::where('status', 0)->orderBy('created_at', 'desc')->get();
        $html = view('frontend.challenges.appends.open', $data)->render();
        return response()->json(["result" => "success", "html" => $html]);
    }

    function getVotingChallenges()
    {
        $data['voting'] = Challenge::where('status', 1)->orderBy('created_at', 'desc')->get();
        $html = view('frontend.challenges.appends.voting', $data)->render();
        return response()->json(["result" => "success", "html" => $html]);
    }

    function getClosedChallenges()
    {
        $data['closed'] = Challenge::where('status', 2)->orderBy('created_at', 'desc')->get();
        $html = view('frontend.challenges.appends.closed', $data)->render();
        return response()->json(["result" => "success", "html" => $html]);
    }

    function getEnterChallenge($slug, $id)
    {
        $challenge = Challenge::where('slug', $slug)->first();
        if($challenge){
            if($challenge->status == 0){
                $exist = Entry::where('challenge_id', $challenge->id)->where('user_id', Auth::user()->id)->first();
                if(!$exist){
                    $photo = Photo::find(Crypt::decrypt($id));
                    if($photo){
                        $entry = Challenge::enterChallenge($challenge->id, $photo->id);
                        $url = URL('challenges/'.$entry->slug);
                        return redirect($url);
                    }
                }
            }
        }return back();
    }

    function getEntries($slug)
    {
        $challenge = Challenge::where('slug', $slug)->first();
        if($challenge){
            $data['entries'] = $challenge->entries;
            $html = view('frontend.challenges.appends.entries', $data)->render();
            return response()->json(["result" => "success", "html" => $html]);
        }
    }

    function getVote($slug)
    {
        $data['challenge'] = Challenge::where('slug', $slug)->first();
        if(count($data['challenge'])){
            if(Auth::check() && $data['challenge']->status == 1){
                $upvotes = Vote::where('challenge_id', $data['challenge']->id)
                                    ->where('user_id', Auth::user()->id)->pluck('photo_id');
                $data['entry'] = null;
                if(count($upvotes)){
                    $data['entry'] = Entry::where('challenge_id', $data['challenge']->id)->where('photo_id', '<>', $upvotes)->where('user_id', '<>', Auth::user()->id)->inRandomOrder()->take(1)->get();
                }else{
                    $data['entry'] = Entry::where('challenge_id', $data['challenge']->id)->inRandomOrder()->take(1)->get();
                }
                return view('frontend.challenges.vote', $data);
            }return redirect('challenges/'.$data['challenge']->slug);
        }return view('errors.404');
    }

    function getSkip(Request $request, $slug)
    {
        $data['challenge'] = Challenge::where('slug', $slug)->first();
        if(count($data['challenge'])){
            if(Auth::check() && $data['challenge']->status == 1){
                $upvotes = Vote::where('challenge_id', $data['challenge']->id)
                                ->where('user_id', Auth::user()->id)->pluck('photo_id');
                if(count($upvotes)){
                    $data['entry'] = Entry::where('id', '<>', Crypt::decrypt($request->entry_id))->where('challenge_id', $data['challenge']->id)->where('user_id', '<>', Auth::user()->id)->where('photo_id', '<>', $upvotes)->take(1)->get();
                }else{
                    $data['entry'] = Entry::where('id', '<>', Crypt::decrypt($request->entry_id))->inRandomOrder()->take(1)->get();
                }
                $html = view('frontend.challenges.appends.vote', $data)->render();
                return response()->json(["result" => "success", "html" => $html]);
            }return redirect('challenges/'.$data['challenge']->slug);
        }return view('errors.404');
    }

    function getVoteUp(Request $request, $slug)
    {
        $data['challenge'] = Challenge::where('slug', $slug)->first();
        if(count($data['challenge'])){
            if(Auth::check()){
                if($data['challenge']->status == 1){
                    $data['photo'] = Photo::find(Crypt::decrypt($request->id));
                    $check_vote = Vote::where('challenge_id', $data['challenge']->id)
                                    ->where('photo_id', $data['photo']->id)
                                    ->where('user_id', Auth::user()->id)->count();
                    if(!$check_vote){
                        $vote = Vote::addData($data['challenge']->id, $data['photo']->id, Auth::user()->id);
                        $entry = Entry::upVote(Crypt::decrypt($request->entry_id));
                        $upvotes = Vote::where('challenge_id', $data['challenge']->id)
                                        ->where('user_id', Auth::user()->id)->pluck('photo_id');
                        Notification::notifyVote($data['photo']->id, Auth::user()->id, $data['photo']->user_id, $data['challenge']->id); // (photo_id, from_user_id, to_user_id, challenge_id)
                        $data['entry'] = Entry::where('id', '<>', $entry->id)->where('challenge_id', $data['challenge']->id)->where('user_id', '<>', Auth::user()->id)->where('photo_id', '<>', $upvotes)->inRandomOrder()->take(1)->get();
                        $html = view('frontend.challenges.appends.vote', $data)->render();
                        return response()->json(["result" => "success", "html" => $html]);
                    }return response()->json(["result" => "invalid"]);
                }return redirect('challenges/'.$data['challenge']->slug);
            }return redirect('challenges/'.$data['challenge']->slug);
        }return view('errors.404');
    }
    
    function getCheck(Request $request, $slug)
    {
        $challenge = Challenge::where('slug', $slug)->first();
        $data['challenge'] = Challenge::checkStatus($challenge->id);
        if($data['challenge']->status == 1){
            $html = view('frontend.challenges.appends.vote-button', $data)->render();
        }else if($data['challenge']->status == 2){
            $html = view('frontend.challenges.appends.close-button', $data)->render();
        }
        return response()->json(["result" => "success", "html" => $html]);
    }

}