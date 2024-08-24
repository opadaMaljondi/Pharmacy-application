<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class RegisterController extends Controller
{
    protected $db_mysql;
    public function __construct()
    {
        $this->db_mysql = config('database.connections.mysql.database');
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'Phone' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = users::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        $token = Auth::guard('api')->login($user);

       return response()->json([
        'message' => 'Register successfully',
        'token'=>$token,
      "user" => $user,
        ], 201);
    }
    /**
     * Login
     */
    public function addInfo(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'Fname' => 'required',
            'Lname' => 'required|string',
            'Country' => 'required',
            'City' => 'required',
            'Type_User' => 'required',
            'weight' => 'required | Integer',
            'birthDate' =>'required',
            'gender' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user= users::find($id);
;

        if(!$user) return response()->json(['not found'],404);
        $user->update(array_merge(
            $validator->validated(),
            ['birthDate' => Carbon::parse($request->birthDate)]
           ));

        $credentials = $request->only(['Phone', 'password']);
        $token = Auth::guard('api')->login($user);
       return response()->json([
        'message' => 'Register successfully',
        'token'=>$token,
        "user" => $user,
    ], 201);





    }

     public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'Phone' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }
        $credentials = $request->only(['Phone', 'password']);
        $token = Auth::guard('api')->attempt($credentials);
if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => Auth::guard('api')->user(),

        ]);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /* public function me()
    {
        return response()->json(auth()->user());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
