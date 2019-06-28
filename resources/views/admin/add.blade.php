@include('layouts.header')
@include('public.tail')
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='/js/jquery-3.3.1.min.js'></script>
    <title>Document</title>
</head>
<body>
<div class="content">
    <form action="{{url('/admin/cate')}}" method='post' enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table>
            <tr>
                <td>商品名称</td>
                <td><input type="text" name='goods_name' id='goods_name'></td>
            </tr>
            <tr>
                <td>商品图片</td>
                <td><input type="file" name='goods_img'></td>
            </tr>
            <tr>
                <td>商品价格</td>
                <td><input type="text" name='goods_mon'></td>
            </tr>
            <tr>
                <td>商品库存</td>
                <td><input type="text" name='goods_num' id='goods_num'></td>
            </tr>
         
            <tr>
                <td></td>
                <td><input type="submit" value='提交' id='sub'></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>
