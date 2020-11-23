<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ustranenie extends Model
{
    protected $table='ustranenie';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
