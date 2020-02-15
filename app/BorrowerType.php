<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowerType extends Model
{
    //
    use SoftDeletes;

    public $table = 'borrower_types';
    protected $fillable = ['type'];
}
