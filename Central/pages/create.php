<?php
ob_start();
session_start();
require_once '../php/dbconnect.php';

// variable declaration to avoid undefined variable errors

$title = "";
 
// if session is set show editor else show message
if( isset($_SESSION['user']) ) {
	
	// select loggedin users detail
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysqli_fetch_array($res);

	// declare user for sql querry
	$user = $userRow['userName'];
	
	
 if ( isset($_POST['btn-submit']) ) {

	 // clean user inputs to prevent sql injections
	$title = trim($_POST['title']);
	$title = strip_tags($title);
	$title = htmlspecialchars($title);		
	
	$myfile = fopen("../localStorage/$title.html", "w") or die("Unable to open file!");
	$txt = $_POST['htmlcontent'];
	fwrite($myfile, $txt);
	fclose($myfile);
	
	$query = "INSERT INTO contentinfo(title,user,filePath) VALUES('$title','$user','../localStorage/$title')";
	$resx = mysqli_query($conn,$query);
	
	header("Location: ../php/home.php");
  
}
?>

<form method="post" name="myform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
	<div>
		<div class="panel-body">
			<div class="input-group">
				<input type="text" ng-model="mytitle" name="title" class="form-control" placeholder="Title*" required maxlength="160" value="<?php echo $title ?>" />
			</div>
		</div>
		<div>
			<div text-angular ng-model="htmlcontent" name="htmlcontent" ></div>
			<button type="submit" class="btn btn-block btn-primary" ng-disabled="myform.$invalid" name="btn-submit">Submit article</button>
		</div>
	</div>
</form>

<?php
}  
else { ?>

<p>{{ message }}</p>	

<?php	 
}
?>
