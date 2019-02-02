<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "full_name" => $this->full_name,
            "course" => $this->course,
            "position_id" => $this->position_id,
            "party_id" => $this->party_id,
            "election_id" => $this->election_id,
            
            //Relationship Eloquent
            "position" => $this->position,
            "party" => $this->party,
            "election" => $this->election,
        ];
    }
}
