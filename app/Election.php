<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $table = "election";
    protected $fillable = ['election_title','start','end'];
}