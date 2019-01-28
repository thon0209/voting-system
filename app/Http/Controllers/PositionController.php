<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Position;
use App\Http\Resources\PositionResource as PositionResource;
use App\Http\Requests\PositionRequest;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::all();
        return PositionResource::collection($position);
    }

    public function getPosition()
    {
        return response()->json(['positions'=>Position::all()]);
    }

    public function store(PositionRequest $request)
    {
        $validated = $request->validated();
        $position = new Position;
        $position->fill(Input::get());
        if($position->save())
        {
            return new PositionResource($position);
        }
    }

    public function update(PositionRequest $request,$id)
    {
        $validated = $request->validated();
        $position = Position::findOrFail($id);
        $position->fill(Input::get());
        if($position->save())
        {
            return new PositionResource($position);
        }
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return response()->json(['message' => 'Deleted']);
    }

}
