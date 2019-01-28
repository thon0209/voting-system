<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table="positions";
    protected $fillable = ['position'];


    protected function candidate()
    {
        return $this->hasMany('App\Candidate');
    }


}
