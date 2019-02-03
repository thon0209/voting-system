<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PollingResource extends JsonResource
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
            "user_id" => $this->user_id,
            "candidate_id" => $this->candidate_id,
            "per_page" => $this->per_age,
            "timestamp_vote" => $this->timestamp_vote,
            "candidate" => $this->candidate,
            "user" => $this->user
        ];
    }
}
