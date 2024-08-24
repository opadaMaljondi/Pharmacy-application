<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $table = "complaints";
    public function pharmacy(){
        return [$this->belongsTo(pharmacy::class,'phar_id'),
         $this->belongsTo(users::class,'user_id') ];
     }


}
