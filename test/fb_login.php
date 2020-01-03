<html>
<head>
    <title>Exam entry</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
    <div id="fb-root"></div>

    <input type="button" value="Sign in" id="sign_in" />
    <input type="button" value="Sign out" id="sign_out" />

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


            $('#sign_in').click(function (e) {
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
        // END fbAsyncInit ///
        
        function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me',{ locale: 'en_US', fields: 'name, email,link,picture' }, function (response) {
                console.log('Good to see you, ' + response.name + '.');
                console.log(response);
                $.post('fb_login_sever.php',{name:response},function(data){//if success
                  if(data=="success"){console.log("login success");}else{console.log("FAIL LOGIN");}}
                );
            });
        }

        // Load the SDK asynchronously
        (function (d) {
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) { return; }
            js = d.createElement('script'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/en_US/all.js";
            ref.parentNode.insertBefore(js, ref);
        }(document));

    </script>
</body>
</html>