<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $table='payments';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

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
