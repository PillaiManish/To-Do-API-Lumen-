<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\ToDo;

class ToDoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list(Request $request){
        return response()->json([
            'status'    => 'success',
            'message'   =>  ToDo::all()
        ],200);
    }

    public function add(Request $request){
        $input = Validator::make($request->all(),[
            'title'         => 'required|min:2', 
            'description'   => 'required|min:2', 
            'priority'      => 'required', 
            'deadline'      => 'required', 
            'completed'     => 'required',
            'status'        => 'required'
        ]);

        if ($input->fails()){
            return response()->json([
                'status' => 'Error',
                'message'=> 'Please check if input are correct'
            ],401);
        }

        Todo::create(['user_id' => auth()->user,'title'=>$request->title,'description' => $request->description,'priority' => $request->priority,'deadline' => $request->deadline,'completed' => $request->completed,'status' => $request->status]);
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Your To Do has been updated. Good Luck'    
        ]);
    }

    
}
