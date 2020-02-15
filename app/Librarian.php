<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Librarian extends User
{
    //
    public function getUserType(){
        return "Librarian";
    }
}
