<?php

namespace cns_webtools;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /*public static function incomplete(){
        return static::where('compelted', 0)->get();
    }*/

    public function scopeIncomplete($query){
        return $query->where('completed',0);   //ep 7.. this is a wrapper around a query..........
        //Scope is not used.
        //you can use now task:;incomplete->where(more conditions)->get();

    }
}
