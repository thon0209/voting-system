<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\PollingResource as PollingResource;
use App\Polling;
use App\User;
use App\Candidate;
use Carbon\Carbon;
use DB;


class PollingController extends Controller
{

    public function index(Request $request)
    {
        $per_page = $request->per_page;
        $vote_log = Polling::latest('id')->paginate($per_page);   
        return PollingResource::collection($vote_log);           
    }

    public function getResults()
    {
        $candidate = Candidate::select('id')->get();  
        $polling = Polling::whereIn('candidate_id',$candidate)
                    ->select('candidate_id',DB::raw('COUNT(candidate_id) as totalVote'))
                    ->groupBy('candidate_id')
                    ->get();   
        return response()->json(['data'=>$polling]);
    }

    public function store(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if(auth()->user()->isVoted === 0) {
            $vote = new Polling;
            $vote = json_decode($request->getContent(),true);
            foreach($vote as $collection){
                Polling::insert([
                    'candidate_id' => $collection['id'],
                    'user_id' => auth()->user()->id,
                    'timestamp_vote' => Carbon::now()
                ]);
            }
            $user->isVoted = '1';
            $user->save();
            return view('polling.index');
        } else {
            return response()->json(['error'=>'Sorry you have already voted!']);
        }

       
    }
}
