<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    protected $table="polling";
    protected $fillable = ['id','user_id'];

    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
