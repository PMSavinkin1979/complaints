<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Main extends Model
{
    protected $table='mains';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
/*
    public function downloads()
    {
        return $this->morphToMany(Download::class,'downloadable');
    }*/

    protected $appends = ['short_zakazchik','short_months','short_zakazchik2'];
    public function getShortZakazchikAttribute($value)
    {
        return Str::limit($this->zakazchik,8);
    }

    public function getShortMonthsAttribute($value)
    {
        return Str::limit($this->months,8);
    }

    public function getShortZakazchik2Attribute($value)
    {
        return Str::limit($this->zakazchik,16);
    }
}
