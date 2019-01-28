<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Election;
use App\Http\Resources\ElectionResource as ElectionResource;
use App\Http\Requests\ElectionRequest;

class ElectionController extends Controller
{
    public function index()
    {
        $election = Election::all();
        return ElectionResource::collection($election);
    }

    public function store(ElectionRequest $request)
    {
        $validated = $request->validated();
        $election = new Election;
        $election->fill(Input::get());
        if($election->save())
        {
            return new ElectionResource($election);
        }
    }

    public function update(ElectionRequest $request,$id)
    {
        $validated = $request->validated();
        $election = Election::findOrFail($id);
        $election->fill(Input::get());
        if($election->save())
        {
            return new ElectionResource($election);
        }
    }

    public function destroy($id)
    {
        $election = Election::findOrFail($id);
        $election->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
