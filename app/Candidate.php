<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = "candidates";
    protected $fillable = ['full_name','course','position_id','party_id','election_id'];

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function party()
    {
        return $this->belongsTo('App\PartyList');
    }

    public function election()
    {
        return $this->belongsTo('App\Election');
    }

}
