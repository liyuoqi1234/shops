<!-- menu -->

@include('layouts/shop')
@include('public/head')
@extends('public/top')

		<div class="modal-content">
		<meta name="csrf-token" content="{{ csrf_token() }}"> 
			<div class="cart-menu">
				<div class="container">
						<div class="divider"></div>
						<div class="cart-2">
							<div class="row">
								
								<div class="col s7">
									<h5><a href="">Fashion Men's</a></h5>
								</div>
							</div>
							<table class="shoucangtab">
								<tr>
					
								
								<td width="25%" align="center" style="background:#fff url(/index/images/xian.jpg) left center no-repeat;">
								<span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
								</td>
								</tr>
								</table>
							<div class="col s5">
								@foreach($data as $v)
								<td width="4%"><input type="checkbox" class="box" cart_id="{{$v->cart_id}}" newp="{{$v->goods_mon*$v->buy_num}}"/></td>

								<img src="{{$v->goods_img}}" width='200'>
								</div>
							<div class="row quantity">
								<div class="col s5">
									<h5>Quantity</h5>
								</div>
						<input type="hidden" id='cart_id' value="{{$v->cart_id}}"> 
						 <div class="col s7">	
						 <table id="tr" class='tr'>
						 <tr>
						 
						<td align="right" num="{{$v->goods_num}}" class="num" >
						<!-- <button class="less">-</button> -->
						<input type="text" class="spinner" value="{{$v->buy_num}}" id="jj" style=width:50px; cart_id="{{$v->cart_id}}" id='buy_num' readonly="true"/>
						<!-- <button class="add" price="{{$v->goods_mon}}">+</button> -->
						</td>
						</tr>
						</div>

								</div>
							</div>
							<div class="row">
								<div class="col s5">
									<h5></h5>
								</div>
								<div class="col s7">
								<th colspan="4"><strong class="orange">￥<b class="newp">{{$v->goods_mon*$v->buy_num}}</b></strong></th>
								</div>
							</div>
							</table>
							<div class="row">
								<div class="col s5">
									<h5>Action</h5>
								</div>
								<div class="col s7">
									<div class="action"><i class="fa fa-trash"><a href='javascript:;' class='del'><a href="{{url('/goods/del',['cart_id'=>$v->cart_id])}}">删除</a></i></div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
						<div class="row">
							<div class="col s7">
								<h6>Total</h6>
							</div>
							<div class="col s5">
							<table>
							<tr>
								<th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
								<td width="50%">总计：<strong class="orange">¥<b id="total">{{$total}}</b></strong></td>
								<td width="40%"><b class="jiesuan" id="jiesuan">去结算</b></td>
								</tr>
							</table>
							</div>
						</div>
					</div>
					<button class="btn button-default">Process to Checkout</button>
					
				</div>
			</div>
		</div>
	</div>
	<!-- end cart menu -->
	<script>
		 $(document).on('click','.add',function(){
            // js改变购买数量
            var _this = $(this);
            var cart_id=_this.prev().attr('cart_id');
			console.log(cart_id);
            var goods_num=parseInt(_this.prev().val())+1;
            var price=_this.attr('price');
            var shuliang = parseInt(_this.prev('input').val());
            // 库存
			var num = _this.parents("tr").attr('goods_num');
			console.log(num);
            if (shuliang >= num) {
                _this.prop('disabled',true);
            }else{
                shuliang+=1;
                _this.prev('input').val(shuliang);
				$('.less').prop('disabled',false);
            }
			getSubTotal(goods_num,price,_this);//小计的
			
        });
		$(document).on('click','.less',function(){
            // js改变购买数量
            var _this = $(this);
            var cart_id=_this.next().attr('cart_id');
            var goods_num=parseInt(_this.next().val())-1;
            var shuliang = parseInt(_this.next('input').val());
            var price=_this.next().next().attr('price');
            if (shuliang <= 1) {
                _this.prop('disabled',true);
            }else{
                shuliang-=1;
                _this.next('input').val(shuliang);
                _this.parents().children("input").last().prop('disabled',false);
				$('.add').prop('disabled',false);

            }
			getSubTotal(goods_num,price,_this);//小计的
			
        });

        // $(document).on('blur','.spinner',function(){
        //     // js改变购买数量
        //     var _this = $(this)
        //     var shuliang = _this.val();
        //     var cart_id=_this.attr('cart_id');
        //     var price=_this.next().attr('price');
			
        //     // 库存
        //     var num=$("#goods_num").val();
        //     // 验证
        //     var reg = /^\d{1,}$/;
        //     if (shuliang ==''|| shuliang<=1|| ! reg.test(shuliang)) {
        //         _this.val(1);
        //     }else if (parseInt(shuliang) >= parseInt(num)) {
        //         _this.val(num);
        //     }else{
        //         _this.val(parseInt(shuliang));
        //     }
        //     var shuliang = _this.val();
		// 	getSubTotal(shuliang,price,_this);//小计的
			
        // });

		      function getSubTotal(goods_num,price,_this) {
				$.get(
					"getSubTotal",
					{goods_num:goods_num,price:price},
					function(res){
						_this.parents('#tr').find('.newp').text(res);
					}
				);
			};

			$('#jiesuan').click(function(){
				$.ajaxSetup({     
				headers: 
				{         
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
					} 
					});
				var cart_id=$('#cart_id').val();
				$.post(
					"orderadd",
					{cart_id:cart_id},
					function(msg){
						if(msg.code==1){
                            alert('跳转支付列表成功');
                            location.href="/goods/order"
                        }else{
                            alert('跳转支付列表失败');
                        }
					}
				)
			})

	</script>
						<!-- <div class="col s7">
									<input type="hidden" id="g_id" name="cart_id" value="{{$v->cart_id}}">
									<input type="hidden" id="goods_num" value="{{$v->goods_num}}">
										<input type="button" class="less" value="-">
										
										<input value="{{$v->buy_num}}" type="text" id='buy_num' style=width:50px;>
										<input type="button" class="add" value="+">
									</div>
								</div> -->