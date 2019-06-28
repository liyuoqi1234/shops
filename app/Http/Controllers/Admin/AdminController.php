<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }

    public function login()
    {
        return view('admin.login');
    }

        public function ass()
    {
        $name = request()->name;
        $u_pwd = request()->pwd;
        // $pwd= md5($u_pwd);
        $res = DB::table('login')->where('name',$name)->where('pwd',$u_pwd)->first();
        if($res){
            session(['id'=>$res->id]);
            return(['code'=>1]);
        }else{
            return(['code'=>2]);
        }
    }

    public function add()
    {
        return view('admin.add');
    }

    public function cate(Request $request)
    {
        $data = request()->except(['_token']);
       
        $path = $request->file('goods_img')->store('public');
        $img=asset('storage'.'/'.$path);
         
        $data['add_time'] = time();
        $res= DB::table('goods')->insert([
            'goods_name'=>$data['goods_name'],
            'goods_num'=>$data['goods_num'],
            'goods_mon'=>$data['goods_mon'],
            'goods_img'=>$img,
            'add_time'=>time()
        ]);
        if($res){
            return redirect('admin/list');
        }
    }


    public function list()
    {
        $redis = new \Redis();
        $redis -> connect('127.0.0.1','6379');
        $redis->incr('num');
        $num = $redis->get('num');
        echo $num;
        $query = request()->all();
        $where=[];
        if($query['goods_name']??''){
            $where[]=['goods_name','like',"%$query[goods_name]%"];
        }
        $data = DB::table('goods')->where($where)->paginate(2);
        return view('admin.list',['data'=>$data,'query'=>$query]);
    }

    public function del($id)
    {
        $data = DB::table('goods')->delete($id);
       if($data){
           return redirect('admin/list');
       }
    }

    public function edit($id)
    {
        $data = DB::table('goods')->where('id',$id)->first();
        return view('admin.edit',['data'=>$data]);
    }

    public function update(Request $request,$id)
    {
        $data = request()->except(['_token']);
        $path = $request->file('gooods_img')->store('public');
        $img=asset('storage'.'/'.$path);
        $data = DB::table('goods')->where(['id'=>$id])->update($data);
        if($data){
            return redirect('admin/list');
        }else{
            return redirect('admin/list');
        }
    }

    public function checkout(){
        // echo \request()->u_email;die;
        $goods_name=\request()->goods_name;
        // echo 111;
        if ($goods_name) {
            $where['goods_name']=$goods_name;
            $count=Db::table('goods')->where($where)->count();
            return ['code'=>1,'count'=>$count];
        }
    }
}
