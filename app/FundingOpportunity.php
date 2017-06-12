<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingOpportunity extends Model
{
    public function getId(){
        $className = get_class($this);
        $className = substr($className, 4);
        $id =  \App\Group::where('model_name', $className)->get();
        if(sizeof($id) > 1){
            echo "Fatal Error.  Non-unique model_name.";
            die();
        }
        else{
            return $id[0]->id;
        }
    }
}
