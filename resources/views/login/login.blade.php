
@include('layouts/shop')
@include('public/head')
@include('public/top')	
	<!-- login -->
	<meta name="csrf-token" content="{{ csrf_token() }}"> 
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>LOGIN</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate" placeholder="USERNAME" required id='name'>
						</div>
						<div class="input-field">
							<input type="password" class="validate" placeholder="PASSWORD" required id='pwd'>
						</div>
						<a href=""><h6>Forgot Password ?</h6></a>
						<a href="javascript:;" class="btn button-default" id='btn'>LOGIN</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->
	
	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="about-us-foot">
				<h6>Mstore</h6>
				<p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit.</p>
			</div>
			<div class="social-media">
				<a href=""><i class="fa fa-facebook"></i></a>
				<a href=""><i class="fa fa-twitter"></i></a>
				<a href=""><i class="fa fa-google"></i></a>
				<a href=""><i class="fa fa-linkedin"></i></a>
				<a href=""><i class="fa fa-instagram"></i></a>
			</div>
			<div class="copyright">
				<span>© 2017 All Right Reserved</span>
			</div>
		</div>
	</div>
	<!-- end footer -->
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
		$('#btn').click(function(){
			var name = $('#name').val();
			var pwd = $('#pwd').val();
			$.post(
				"add",
				{name:name,pwd:pwd},
				function(msg){
					if(msg.code==1){
                        alert('登陆成功');
                        location.href="/"
                    }else{
                        alert('登陆失败');
                    }
				}
			)
			return false;
		})

	})
</script>

