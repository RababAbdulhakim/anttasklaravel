<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dayes extends Model
{
    //
    protected  $table = 'dayes';
    
    public $fillable =['data','day_id','table','summary'];
}
