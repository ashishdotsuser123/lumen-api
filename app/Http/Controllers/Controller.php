<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $ApiArray;

    public function __construct()
    {
        $this->apiArray = array();
        $this->apiArray['status'] = false;
        $this->apiArray['data'] = NULL;
        $this->apiArray['message'] = NULL;
    }
}
