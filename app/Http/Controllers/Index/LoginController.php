<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function add()
    {
        $name = request()->name;
        $pwd = request()->pwd;
        $res = DB::table('login')->where('name',$name)->where('pwd',$pwd)->first();
        if($res){
            session(['login_id'=>$res->login_id]);
            return (['code'=>1]);
        }else{
            return (['code'=>2]);
        }
    }

    public function reg()
    {
        return view('login.reg');
    }

    public function cate()
    {
       $data = request()->all();
        $res = DB::table('login')->insert($data);
        if($res){
            return (['code'=>1]);
        }else{
            return (['code'=>2]);
        }
    }
}
