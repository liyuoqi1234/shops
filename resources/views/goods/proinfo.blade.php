
@include('layouts/shop')
@include('public/head')
@extends('public/top')

	
	<!-- wishlist -->
	<div class="wishlist section">
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
		<div class="container">
			<div class="pages-head">
				<h3>WISHLIST</h3>
			</div>
			@foreach($res as $v)
			<div class="content">
				<div class="cart-1">
					<div class="row">
						<div class="col s5">
							<h5>Image</h5>
						</div>
						<div class="col s7">
						<img src="{{$v->goods_img}}" >
						</div>
					</div>
					
					<div class="row">
						<div class="col s5">
							<h5>Name</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$v->goods_name}}</a></h5>
						</div>
						<input type="hidden" id="id" value="{{$v->id}}">
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Stock Status</h5>
						</div>
						<div class="col s7">
						<input type="hidden" id="g_id" name="id" value="{{$v->id}}">
						<input type="hidden" id="goods_num" value="{{$v->goods_num}}">
							<input type="button" class="less" value="-">
							<input type="text" style=width:50px; value="1" id="buy_num"  />
							<input type="button" class="add" value="+">
					</td>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Price</h5>
						</div>
						<div class="col s7">
						<th><h5><strong class="orange">￥<b id="price" class='asd'>{{$v->goods_mon}}</b></strong></h5></th>
						</div>
						@endforeach
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Action</h5>
						</div>
						<div class="col s7">
							<h5><i class="fa fa-trash"></i></h5>
						</div>
					</div>
					<div class="row">
						<div class="col 12">
							<button class="btn button-default" id='sub'>SEND TO CART</button>
						</div>
					</div>
				</div>
				

	
</body>
</html>
<script>
	   $.ajaxSetup({     
        headers: 
        {         
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
            } 
            });
	var goods_num=$("#goods_num").val();
	$('.add').click(function(){
		var buy_num=parseInt($('#buy_num').val());
		if(buy_num>=goods_num){
			$(this).prop('disabled',true);
		}else{
            buy_num+=1;
            $('#buy_num').val(buy_num);
            //-生效
            $('.less').prop('disabled',false);
        } 
		newprice();
	})

	$('.less').click(function(){
		var buy_num=parseInt($('#buy_num').val());
		if(buy_num<=1){
			$(this).prop('disabled',true);
		}else{
			buy_num-=1;
			$('#buy_num').val(buy_num);
			$('.add').prop('disabled',false);
		}
		newprice();
	})

	    $('#buy_num').blur(function(){
        var _this=$(this);
        var buy_num=_this.val();
        var reg=/^\d+$/;
        //为空||购买数量<=1||不是数字
        if(buy_num==''||buy_num<=1||!reg.test(buy_num)){
            _this.val(1);
        }else if(parseInt(buy_num)>=parseInt(goods_num)){
            _this.val(goods_num);
        }else{
            buy_num=parseInt(buy_num);
            _this.val(buy_num);
        }
		newprice();
    })

	     function newprice() {
         var id=$('input[name=id]').val();
         var buy_num=$('#buy_num').val();
         $.get(
             'check',
             {id:id,buy_num:buy_num},
             function (res) {
                 $('#price').text(res);
             }
         )
     }

    $("#sub").click(function(){
            //获取商品id 购买数量
            var id=$('#id').val();  
            var buy_num=$('#buy_num').val();
      $.post(
          "{{url('goods/addca')}}",
          {id:id,buy_num:buy_num},
          function(res){
            if(res.code==1){
				alert('加入购物车成功');
				location.href="/goods/goods"
			}else{
				alert('此商品已存在');
			}
          }
        );
        return false;
            
        })
</script>