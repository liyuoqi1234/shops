<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='/js/jquery-3.3.1.min.js'></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Document</title>
</head>
<body>
    <form action="">
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name='name' id='name'></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" name='pwd' id='pwd'></td>
            </tr>
            <tr>
                <td><button id='sub'>登陆</button></td>
                <!-- <td><a href="/login/reg">注册</a></td> -->
            </tr>
        </table>
    </form>
</body>
</html>
<script>
    $(function(){
        $.ajaxSetup({     
        headers: 
        {         
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
            } 
            });
            $('#sub').click(function(){
                var name=$('#name').val();
                var pwd=$('#pwd').val();
                $.post(
                    "ass",
                    {name:name,pwd:pwd},
                    function(msg){
                        if(msg.code==1){
                            alert('登陆成功');
                            location.href="/admin/admin"
                        }else{
                            alert('登陆失败');
                        }
                       
                    }
                )
                return false;     
            });
           
    })
</script>