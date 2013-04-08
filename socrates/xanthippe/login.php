<!DOCTYPE html>
<html lang=en>
	<head>
		<meta charset=UTF-8>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="container" style="text-align: center;">
			<h1>Login</h1>
			<p>
				This class website requires you to authenticate with Mozilla Persona.<br />
				You must login using your e-mail that is on file with the school.<br />
				This will allow you to view the lessons, submit assignments and participate in the course.
			</p>
			<button id=login><img src="images/plain_sign_in_blue.png"></button>
			<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
			<script src="https://login.persona.org/include.js"></script>
			<script>
			// When the login button is clicked, start the login process.
			var getQueryParameter = function(parameter) {
	if (window.location.search === '') {
		return null;
	}
	var queryStrings = window.location.search.substring(1).split('&');
	for (var ii = queryStrings.length - 1; ii >= 0; ii--) {
		var queryParts = queryStrings[ii].split('=');
		if (queryParts[0] === parameter) {
			return queryParts[1];
		}
	}
	return null;
};
			$('#login').click(function () {
				navigator.id.request();
			});

			navigator.id.watch({
				loggedInUser: null,
				onlogin: function (assertion) {
					// Verify the assertion against our local authorization service.
					$.ajax({
						type: 'POST',
						url: 'service/auth/index.php',
						data: { assertion: assertion },
						success: function (res, status, xhr) {
							window.location = 'http://<?php echo $_SERVER['SERVER_NAME']; ?>'+getQueryParameter('redirect');
						},
						error: function (xhr, status, err) {
							alert('Login failure: ' + err);
						}
					});
				},
				// This won't ever fire in the example.
				onlogout: function () {}
			});
			</script>
		</div>
	</body>
</html>