<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vidgarantiy extends Model
{
    protected $table='vid_garantiy';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
