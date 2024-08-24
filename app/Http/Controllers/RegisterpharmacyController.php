<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Pin;
use App\Models\pharmacy;
use App\Events\NewNotification;
use App\Notifications\SendEmail;
use Illuminate\Support\Facades\Notification;
use Dotenv\Parser\Value;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
class RegisterpharmacyController extends Controller
{

    protected $db_mysql;
    public function __construct()
    {
        $this ->db_mysql= config('database.connections.mysql.database');

    }
    /**
     * Register
     */

    public function login(Request $request)
    {
     $validator =Validator::make($request->all(),[

         'Phone'=>'required|string|email',
         'password'=>'required|string|min:8',
     ]);
     if ($validator->fails())
     {
         return response()->json($validator->errors()->toJson(),422);
     }
     $credentials=$request->only(['Phone','password']);

     if(!$token=auth()->guard('pharmacy-api')->attempt($credentials))
     {
       return response()->json(['error'=>'Unauthorized'],401);
     }
     $pharmacy = Auth::guard('pharmacy-api')->user();

     return response()->json([
         'access_token'=>$token,
         'pharmacy'=>$pharmacy,

       ]);

    }
    public function logout()
    {
        Auth::gurd('pharmacy-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function delete( $id){
        $pharmacy = pharmacy::find($id);
        $result = $pharmacy->delete();
        if($result){
            return response()->json([
                'message'=>' A pharmacy Deleted Successfully'

            ],201);
         } else{
            return response()->json([
                'message'=>'pharmacy Not Deleted '

            ],400);
            }
        }
}



