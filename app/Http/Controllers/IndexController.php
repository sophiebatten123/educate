<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        return inertia('index',
        [
            //go to web dev vue and index chech attribute it will be there this message
            'message' => "Hi from laravel, yo"
        ]);
    }
    public function show(){
        return inertia('show',
        [
            //go to web dev vue and index chech attribute it will be there this message
            'message' => "Hi from laravel, yo"
        ]);
    }

}
