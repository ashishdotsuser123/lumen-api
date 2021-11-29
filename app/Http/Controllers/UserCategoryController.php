<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserCategory;
use App\Http\Requests\UserCategoryRequest;

class UserCategoryController extends Controller
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
        $this->apiArray['state'] = 'Categories list';
        try {
            $category = Auth::user()->categories()->get();

            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Category fetch successfully.";
            $this->apiArray['data'] = $category;
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
    public function store(UserCategoryRequest $request)
    {
        $this->apiArray['state'] = 'Categories store';
        try {
        	Auth::user()->categories()->create($request->all());

            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Category added successfully.";
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
        $this->apiArray['state'] = 'Categories show';
        try {
            $category = UserCategory::where('id', $id)->first();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Category fetch successfully.";
            $this->apiArray['data'] = $category;
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
    public function update(UserCategoryRequest $request, $id)
    {
        $this->apiArray['state'] = 'Categories update';
        try {
            $category = UserCategory::find($id);
            
            if(empty($category)) { 
                throw new \Exception("Category not found!");
            }
            
            if($validator->fails()) { 
                throw new \Exception($validator->messages()->first());
            }

        	$category->fill($request->all())->save();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Category updated successfully.";
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
        $this->apiArray['state'] = 'Categories delete';
    	try {
    		UserCategory::destroy($id);
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Category deleted successfully.";
    	} catch (Exception $e) {
    		$this->apiArray['message'] = $e->getMessage();
    	}

        return response()->json($this->apiArray);
    }
}
