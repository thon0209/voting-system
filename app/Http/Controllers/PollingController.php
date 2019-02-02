<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Polling;


class PollingController extends Controller
{
    public function store(Request $request)
    {
        $vote = new Polling;
        $vote = json_decode($request->getContent(),true);

        foreach($vote as $collection){
            Polling::insert([
                'candidate_id' => $collection['candidate_id'],
                'user_id' => auth()->user()->id
            ]);
        }
        
    }
}
