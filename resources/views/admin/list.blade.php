
<form action="">
    <input type="text" name='goods_name' value="{{$query['goods_name']??''}}" placeholder="请输入商品名称">
    <button>搜索</button>
</form>
<link rel="stylesheet" href="{{asset('css/page.css')}}" type="text/css">
<form action="">
    <table border=1>
        <tr>
            <td>id</td>
            <td>商品名称</td>
            <td>商品图片</td>
            <td>商品数量</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        @if($data)
        @foreach($data as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>
             <td><img src="{{$v->goods_img}}" width='100'></td>
            </td>
            <td>{{$v->goods_num}}</td>
            <td>{{date('Y-m-d ',$v->add_time)}}</td>
            <td>
                <a href="{{url('/admin/del',['id'=>$v->id])}}">删除</a>
                <a href="{{url('/admin/edit',['id'=>$v->id])}}">编辑</a>
            </td>
        </tr>
        @endforeach
         @endif
    </table>
   {{$data->appends($query)->links()}}
</form>