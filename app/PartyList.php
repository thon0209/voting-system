<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartyList extends Model
{
    protected $table="partylist";
    protected $fillable = ['party_name'];

    public function candidate()
    {
        return $this->hasMany('App\Candidate');
    }

}
