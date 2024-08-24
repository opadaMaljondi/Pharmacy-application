<?php

namespace App\Models;
use App\Models\users;
use App\Models\pharmacy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logging extends Model
{
    use HasFactory;
    protected $table = 'loggings';

    public function user(){
        return $this->belongsTo(users::class,'user_id');
    }
    public function pharmacy(){
        return $this->belongsTo(pharmacy::class,'pharmacy_id');
    }

}
