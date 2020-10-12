<!Doctype html>
<html>
	<head>
			<link href="assest/css/bootstrap.css" rel="stylesheet">
			<link href="assest/css/style.css" rel="stylesheet" type="text/css">
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />			<title>Love calculator - Sign Up</title>
	</head>
	<body>
					<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
				<a class="navbar-brand" href="#">Love Calculator</a>
				<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
					<span class="navbar-toggler-icon"></span> 
				</button> 
				<div class="collapse navbar-collapse" id="navbarSupportedContent"> 
					<ul class="navbar-nav mr-auto"> 
						<li class="nav-item active"> <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a> </li> 
						<li class="nav-item"> <a class="nav-link" href="#">Contact us</a> </li> 
					</ul> 
										<a href="./register.php#signup" class="btn btn-primary sign-up">sign up</a>
					<a href="./register.php#login" style="margin-left: 5px;" class="btn btn-secondary login">Login</a>
										<form class="form-inline my-2 my-lg-0"  style="margin-left: 5px;"> 
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> 
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> 
					</form>
				</div> 
			</nav>
		<div class="container">
		
<form method="POST" action="" id="signup">
	<h1 style="color:black">Register</h1>
	<p class="text-center mt-2"> Please fill the form below to register.  It is quick and easy</p>
	<div class="form-group">
		<label for="username" class="required">
			Username
		</label>
		<input name="username" class='form-control' type="text" placeholder="Enter a unique name">
		<small>
		</small>
	</div>
	<div class="form-group">
		<label class="required">Password</label>
		<input type="password" name="password" class="form-control">
		<small>
		</small>
	</div>
	<div class="form-group">
		<label class="required">Confirm Password</label>
		<input type="password" name="repassword" class="form-control">
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>