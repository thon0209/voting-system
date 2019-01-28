<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Candidate;
use App\Http\Resources\CandidateResource as CandidateResource;
use App\Http\Requests\CandidateRequest;

class CandidateController extends Controller
{
    public function index()
    {
        $candidate = Candidate::with('position','party')->get();
        return CandidateResource::collection($candidate);
    }

    public function store(CandidateRequest $request)
    {
        $validated = $request->validated();
        $candidate = new Candidate;
        $candidate->fill(Input::get());
        if($candidate->save()) {
            return new CandidateResource($candidate);
        }
    }

    public function update(CandidateRequest $request,$id)
    {
        $validated = $request->validated();
        $candidate = Candidate::findOrFail($id);
        $candidate->fill(Input::get());
        if($candidate->save())
        {
            return new CandidateResource($candidate);
        }
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
