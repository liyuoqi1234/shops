<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('/admin/update/'.$data->id)}}" method='post' enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table>
            <tr>
                <td>商品名称</td>
                <td><input type="text" name='goods_name' value='{{$data->goods_name}}'></td>
            </tr>
            <tr>
                <td>商品图片</td>
                <td><img src="{{config('app.img_url')}}{{$data->goods_img}}" width=250px><input type="file" name='goods_img' ></td>
               
            </tr>
            <tr>
                <td>商品库存</td>
                <td><input type="text" name='goods_num' value='{{$data->goods_num}}'></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value='修改'></td>
            </tr>
        </table>
    </form>
</body>
</html>