<?php
ob_start();
session_start();

if( isset($_SESSION['user'])!="" ){
	header("Location: home.php");
}

include_once 'dbconnect.php';

// variable declaration to avoid undefined variable errors

$_name = "";
$_email = "";
$_pass = "";

$nameError = "";
$emailError = "";
$passError = "";

$error = false;

if ( isset($_POST['btn-signup']) ) {
  
	// clean user inputs to prevent sql injections
	$_name = trim($_POST['name']);
	$_name = strip_tags($_name);
	$_name = htmlspecialchars($_name);
  
	$_email = trim($_POST['email']);
	$_email = strip_tags($_email);
	$_email = htmlspecialchars($_email);
  
	$_pass = trim($_POST['pass']);
	$_pass = strip_tags($_pass);
	$_pass = htmlspecialchars($_pass);
  
	// basic name validation
	if (empty($_name)) {
	$error = true;
	$nameError = "Please enter a username.";
	} else if (strlen($_name) < 3) {
	$error = true;
	$nameError = "Name must have atleat 3 characters.";
	} else if (!preg_match("/^[a-zA-Z ]+$/",$_name)) {
	$error = true;
	$nameError = "Name must contain alphabets and space.";
	}
  
	//basic email validation
	if ( !filter_var($_email,FILTER_VALIDATE_EMAIL) ) {
	$error = true;
	$emailError = "Please enter valid email address.";
	} else {
	// check email exist or not
	$query = "SELECT userEmail FROM users WHERE userEmail='$_email'";
	$result = mysqli_query($conn,$query);
	$count = mysqli_num_rows($result);
	if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
		}
	}
	
	// password validation
	if (empty($_pass)){
	$error = true;
	$passError = "Please enter password.";
	} else if(strlen($_pass) < 6) {
	$error = true;
	$passError = "Password must have atleast 6 characters.";
	}
  
	// password encrypt using SHA256();
	$password = hash('sha256', $_pass);
  
	// if there's no error, continue to signup
	if( !$error ) {
   
		$query = "INSERT INTO users(userName,userEmail,userPass,joinDate) VALUES('$_name','$_email','$password',NOW())";
		$res = mysqli_query($conn,$query);
    
		if ($res) {
		$errTyp = "success";
		$errMSG = "Successfully registered, you may login now";
		unset($_pass);
		} else {
		$errTyp = "danger";
		$errMSG = "Something went wrong, try again later..."; 
		} 
	} 
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
    <title>Central</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
<body>
<div class="container">
	<div id="login-form">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">   
			<div class="col-md-12">       
				<div class="form-group">
					<h2 class="">Sign Up.</h2>
				</div>       
				<div class="form-group">
					<hr/>
				</div>

<?php
if ( isset($errMSG) ) {   
?>
				<div class="form-group">
					<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
						<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
					</div>
				</div>
<?php
   }
?>
            
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" name="name" class="form-control" placeholder="Enter Username" maxlength="50" value="<?php echo $_name ?>" />
					</div>
					<span class="text-danger"><?php echo $nameError; ?></span>
				</div>
            
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $_email ?>" />
					</div>
					<span class="text-danger"><?php echo $emailError; ?></span>
				</div>
            
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
					</div>
					<span class="text-danger"><?php echo $passError; ?></span>
				</div>
            
				<div class="form-group">
					<hr/>
				</div>
            
				<div class="form-group">
					<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
				</div>
            
				<div class="form-group">
					<hr/>
				</div>
            
				<div class="form-group">
					<a href="login.php">Sign in Here...</a>
				</div>
			
				<div class="form-group">
					<a href="../">Go back to Central</a>
				</div>       
			</div>  
		</form>
    </div> 
</div>
</body>
</html>
<?php ob_end_flush(); ?>