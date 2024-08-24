<?php

namespace App\Http\Controllers;

use App\Models\logging;
use Illuminate\Http\Request;

class LoggingController extends Controller
{
public function addlogging($id,$pharOrUser,$action){
$logginig=new logging();
    if($pharOrUser==1){

$logginig->user_id=$id;
$logginig->action=$action;
    }else{


     $logginig->pharmacy_id=$id;
     $logginig->action=$action;

    }
return $logginig->save();
}


}
