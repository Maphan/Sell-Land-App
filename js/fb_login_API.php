<script type="text/javascript">
		window.fbAsyncInit = function () {
            FB.init({
                appId: '322721034854533',
                cookie: true,
                status: true,
                xfbml: true
            }); 
            FB.Event.subscribe('auth.authResponseChange', function (response) {
                if (response.status === 'connected') {
                    
                    testAPI();
                } else{
                    console.log("You not login");
                }
            });


            $('.fb_api').click(function (e) {
                e.preventDefault();
                FB.login(function (response) {
                    if (response.authResponse) {
                        //return window.location = '/auth/facebook/callback';
                    }
                });
            });
            $('#sign_out').click(function (e) {
                FB.logout(function (response) {
                    console.log("Here logout response", response);
                });
            });

        };
        // END fbAsyncInit //
        
        function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me',{ locale: 'en_US', fields: 'name, email,link,picture' }, function (response) {
                console.log('Good to see you, ' + response.name + '.');
                console.log(response);
				console.log(response.email);
				//check user in system
				var url_fb_checkUser='<?php echo $level."register/check_userSystem_sever.php";?>';
				$.ajax({
					url:url_fb_checkUser,
					type: 'POST',
					data: {email:response.email},
					success:function(data_check){
						console.log(data_check);
						if(data_check=='0'){//ยังไม่สมัคร
							toSignup(response.name,response.email,response.link);
						}else if(data_check=='1'){//สมัครแล้ว
							var urlGetpass='<?php echo $level."phpObject/get_passUser_sever.php";?>';
							var passAccess="dfmfd894g9er4gb54dfv984e9r4g9e4h9fv5b4e984h9sdfSSDfg849er4g9Df98g9ef549g5df4_jaruwat";
							$.ajax({
								url:urlGetpass,
								type: 'POST',
								data:{email:response.email,accessCode:passAccess},
								success:function(datagetpssUser){
									console.log(datagetpssUser);
									toSignin(response.email,datagetpssUser);
								}
							})
						}
					}
				})
            });
        }
		
		//func to signup
		function toSignup(Name,Email,Linkfb){
			var urltosignup='<?php echo $level."SignUp.php";?>';
			var keys=new Array("username","email","linkfb");
			var values=new Array(Name,Email,Linkfb,);
			openWindowWithPost(urltosignup,"_top",keys,values);
		}
		//func to login
		function toSignin(Email,Pass){
			var urlSigninSever='<?php echo $level."signin/login_sever.php";?>';
			$.ajax({
				url: urlSigninSever,
				data:{email:Email,password:Pass},
				type: 'POST',
				success: function(data){
					location.reload();
				}
			});
		}
	
        // Load the SDK asynchronously//
        (function (d) {
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) { return; }
            js = d.createElement('script'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/en_US/all.js";
            ref.parentNode.insertBefore(js, ref);
        }(document));
</script>