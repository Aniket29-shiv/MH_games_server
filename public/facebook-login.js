window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : fbkey, // FB App ID322558735297480
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : fbversion // use graph api version 2.8 / v3.3
      
    });
    
    // Check whether the user already logged in
    /*FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            getFbUserData();
        }
    });*/
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
    
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email'},
    function (response) {
		
		var fbid = response.id;
		var fname = response.first_name;
		var lname = response.last_name;
		var email = response.email;
       var name=fname+' '+lname;
	
		var dataString = 'id='+ fbid+'&name='+name+'&email='+email; 

		$.ajax({
			   type: "POST",
			   url: "public/login_profile.php",
			   data: dataString,
			   cache: false,
			   success: function(data){
			   		window.location.href = "public/social-profile.php";
				}
			});
    });
}

// Logout from facebook
function fbLogout() {
    FB.logout(function() {
       /* document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
        document.getElementById('fbLink').innerHTML = '<img src="img/facebook.png"/>';
        document.getElementById('userData').innerHTML = '';
        document.getElementById('status').innerHTML = 'You have successfully logout from Facebook.';*/
    });
}