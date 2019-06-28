
@include('layouts/shop')
@include('public/head')
@extends('public/top')
	<!-- register -->
	<div class="pages section">
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
		<div class="container">
			<div class="pages-head">
				<h3>REGISTER</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" placeholder="EMAIL" class="validate" required name='name'id="name">
						</div>
						<div class="input-field">
							<input type="password" placeholder="PASSWORD" class="validate" required id="pwd"> 
						</div>
						<div class="btn button-default" id='stn'>REGISTER</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end register -->
	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
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
		$('#stn').click(function(){
			var name = $('#name').val();
			var pwd=$('#pwd').val();
			$.post(
				"cate",
				{name:name,pwd:pwd},
				function(msg){
					if(msg.code==1){
                        alert('注册成功');
                        location.href="/login/login"
                    }else{
                        alert('注册成功');
                    }
				}
			)
			return false;
		})
	})
</script>