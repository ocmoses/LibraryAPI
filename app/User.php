<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BorrowerType;
use App\Book;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'borrower_type', 'username', 'course', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isTeacher(){
        return $this->getUserType() == "Teacher";
    }

    public function isSeniorStudent(){
        return $this->getUserType() == "Senior student";
    }

    public function isJuniorStudent(){
        return $this->getUserType() == "Junior student";
    }

    public function isStudent(){
        return $this->getUserType() == "Senior student" || getUserType() == "Junior student";
    }

    public function isLibrarian(){
        return $this->getUserType() == "Librarian";
    }

    public function getUserType(){
        return ($this->borrower_type_id != null) ? BorrowerType::find($this->borrower_type_id)->type : "Librarian";
    }

    public function requestBook($book_title){
        if($this->getUserType() != 'Librarian'){
            //call the request root
        }
    }

    public function alreadyRequestedBook($book_title){
        $oldRequests = BookRequest::all()->filter(function($requested) use ($book_title){
            return Book::find($requested->book_id)->title == $book_title && $this->id == $requested->borrower_id;
        });

        return count($oldRequests) > 0;
    }
}
