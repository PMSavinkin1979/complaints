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

    protected $appends = ['short_zakazchik','name_months','short_zakazchik2'];
    public function getShortZakazchikAttribute($value)
    {
        return Str::limit($this->zakazchik,8);
    }

    public function getNameMonthsAttribute($value)
    {
        $ar = array('"01"'=>'Январь','"02"'=>'Февраль','"03"'=>'Март','"04"'=>'Апрель',
            '"05"'=>'Май','"06"'=>'Июнь','"07"'=>'Июль',
            '"08"'=>'Август','"09"'=>'Сентябрь', '"10"'=>'Октябрь',
            '"11"'=>'Ноябрь','"12"'=>'Декабрь');
        if (array_key_exists($this->months, $ar))
        {
            return $ar[$this->months];
        }
        if (array_key_exists($this->pay_months, $ar))
        {
            return $ar[$this->pay_months];
        }

        return '';
    }

    public function getShortZakazchik2Attribute($value)
    {
        return Str::limit($this->zakazchik,16);
    }
}
