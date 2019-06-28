<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        $res = DB::table('goods')->get();
        return view('index.index',['res'=>$res]);
    }


}
