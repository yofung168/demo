<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model
{
    //
    public $timestamps = true;
    protected $guarded = [];

    protected $primaryKey = 'id';
}
