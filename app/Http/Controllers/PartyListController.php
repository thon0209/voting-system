<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\PartyList;
use App\Http\Resources\PartyListResource as PartyListResource;
use App\Http\Requests\PartyListRequest;

class PartyListController extends Controller
{
    public function index()
    {
        $party = PartyList::all();
        return PartyListResource::collection($party);
    }

    public function getParty()
    {
        return response()->json(['parties'=>PartyList::all()]);
    }

    public function store(PartyListRequest $request)
    {
        $validated = $request->validated();
        $party = new PartyList;
        $party->fill(Input::get());
        if($party->save())
        {
            return new PartyListResource($party);
        }
    }

    public function update(PartyListRequest $request,$id)
    {
        $validated = $request->validated();
        $party = PartyList::findOrFail($id);
        $party->fill(Input::get());
        if($party->save())
        {
            return new PartyListResource($party);
        }
    }

    public function destroy($id)
    {
        $party = PartyList::findOrFail($id);
        $party->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
