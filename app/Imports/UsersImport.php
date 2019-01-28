<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $fillable=['file'];

    public function model(array $row)
    {
        return new User([
            'name'      => $row[0],
            'course'    => $row[1],
            'username'  => $row[2],
            'email'     => $row[3], 
            'password'  => Hash::make($row[4]),
            'isVoted'   => $row[5], 
            'isAdmin'   => $row[6]
        ]);
    }
}
