<?php
ob_start();
session_start();
require_once 'php/dbconnect.php';

// if session is set get user data.
if( isset($_SESSION['user']) ) {
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysqli_fetch_array($res); ?>
	
	<!--  Hide Log in button -->
	<style type="text/css"> 
	#loginbutton{
		display:none;
		}
	</style>
	
<?php
}
else { ?>

	<!-- Hide Hi' -->
	<style type="text/css"> 
	#logininfo{
		display:none;
		}
	</style>
	
<?php
}
?>

<!DOCTYPE html>

<html lang="hr">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
    <title>Central</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">
	
	<!-- Font Awesome -->	
	<script src="https://use.fontawesome.com/2e0346f2d5.js"></script>
	
	 <!-- AngularJS -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script>
	
	<!-- textAngular -->
	<link rel='stylesheet' href='css/textAngular.css'>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.5.0/textAngular-rangy.min.js'></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.5.0/textAngular-sanitize.min.js'></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.5.0/textAngular.min.js'></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
<body>
	<div class="container">	
		<div class="header">
			<h1>Welcome to Central</h1>
		</div>		
		<div ng-app="myApp">		
		<div ng-controller="Collapse">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" aria-expanded="false" ng-click="isNavCollapsed = !isNavCollapsed">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				</div>
				<div class="navbar-collapse collapse" uib-collapse="isNavCollapsed">
					<ul class="nav navbar-nav">
						<li><a href="#home">Home</a></li>
						<li><a href="#explore">Explore</a></li>
						<li><a href="#create">Create</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a id="loginbutton" href="php/login.php">Log in</a></li>
						<li><a href="php/home.php" id="logininfo"><span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userName']; ?>&nbsp;</a></li>
					</ul>
				</div>
			  </div>
			</nav>
		</div>

		<div ng-view ></div>
	
		</div>	
	</div>		

    <!-- Include all compiled plugins (below), or include individual files as needed -->
	
	<script src="js/ui-bootstrap-tpls-2.2.0.min.js"></script>
	<script src="js/app.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>