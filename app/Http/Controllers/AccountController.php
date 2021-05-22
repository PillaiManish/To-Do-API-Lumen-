<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request){
        $input = Validator::make($request->all(),[
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:8'
        ]);

        if ($input()->fails()){
            return response()->json([
                'status' => 'Error',
                'message'=> 'Please check if input are correct'
            ],401);
        }

        if (! $token = auth()->attempt($input)){
            return response()->json([
                'status' => 'Error',
                'message'=> 'Wrong username or password'
            ],401);
        }

        return $this->respondWithToken($input);
    }

    public function register(Request $request){
        $input = Validator::make($request->all(),[
            'name'      =>  'required|min:2',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:8'
        ]);  
        
        if ($input()->fails()){
            return response()->json([
                'status' => 'Error',
                'message'=> 'Please check if input are correct'
            ],401);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
        ]);

        return response()->json([
            'status'    => 'Success',
            'message'   => 'User has been successfully registered'
        ],200);
    }

 
    public function logout(Request $request){
        auth()->logout();

        return response()->json([
            'status'    => 'Success',
            'message'   => 'You have been successfully logout'
        ],200);
    }

    public function delete(Request $request){
        User::find(auth()->user)->delete();

        return response()->json([
            'status'    => 'Success',
            'message'   => 'Your account has been successfully deleted'
        ], 200);        
    }
}
