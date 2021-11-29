<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserTodo;
use App\Http\Requests\UserTodoRequest;

class UserTodoController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->apiArray['state'] = 'todos list';
        try {
            $todo = Auth::user()->todos();
            if ($request->type == 'day' && !empty($request->filter)) {
                $todo = $todo->whereDate('todo_date', date('Y-m-d', strtotime($request->filter)));
            } elseif ($request->type == 'month' && !empty($request->filter)) {
                $todo = $todo->whereMonth('todo_date', date('m', strtotime($request->filter)));
            }
            $todo = $todo->get();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Todo fetch successfully.";
            $this->apiArray['data'] = $todo;
        } catch (Exception $e) {
        	$this->apiArray['message'] = $e->getMessage();
        }

        return response()->json($this->apiArray);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserTodoRequest $request)
    {
        $this->apiArray['state'] = 'todos store';
        try {
        	Auth::user()->todos()->create($request->all());

            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Todo added successfully.";
        } catch (Exception $e) {
        	$this->apiArray['message'] = $e->getMessage();
        }

        return response()->json($this->apiArray);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->apiArray['state'] = 'todos show';
        try {
            $todo = UserTodo::where('id', $id)->first();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Todo fetch successfully.";
            $this->apiArray['data'] = $todo;
        } catch (Exception $e) {
        	$this->apiArray['message'] = $e->getMessage();
        }

        return response()->json($this->apiArray);
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTodoRequest $request, $id)
    {
        $this->apiArray['state'] = 'todos update';
        try {
            $todo = UserTodo::find($id);
            
            if(empty($todo)) { 
                throw new \Exception("Todo not found!");
            }

        	$todo->fill($request->all())->save();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Todo updated successfully.";
        } catch (Exception $e) {
        	$this->apiArray['message'] = $e->getMessage();
        }

        return response()->json($this->apiArray);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->apiArray['state'] = 'todos delete';
    	try {
    		UserTodo::destroy($id);
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Todo deleted successfully.";
    	} catch (Exception $e) {
    		$this->apiArray['message'] = $e->getMessage();
    	}

        return response()->json($this->apiArray);
    }
}
