<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blog extends Controller
{
    //

    public function create(){
        return view('create');
    }

    public function store(Request $request){


        $this->validate($request,[
            "name"=> "required|min:3|string",
            "email"=>"required|email",
            "password"=>"required|min:6",
            "address"=>"required|min:10",
            "linkedin"=>"required|min:3|url"
        ]);


            echo "message successed";

            $data = $request->all();
            return view("users", [ "data" =>$data]);
    }

    // public function userInfo(){

    // }
}
