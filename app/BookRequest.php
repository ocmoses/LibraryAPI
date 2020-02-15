<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class BookRequest extends Model
{
    //
    use SoftDeletes;
    
    public $table = 'book_requests';
    protected $fillable = ['borrower_id', 'status', 'book_id'];


    public function getMatchingRequests(){
        return BookRequest::all()
                ->filter(function($one){
                        return $one->book_id == $this->book_id && $one != $this;
                    });
    }

    public function getRequesterType(){
        return User::find($this->borrower_id)->getUserType();
    }
}
