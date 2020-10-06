<?php
ob_start();
session_start();
require_once 'dbconnect.php';
 
// if session is not set this will redirect to login page
if( !isset($_SESSION['user']) ) {
	header("Location: login.php");
	exit;
}

// variable declaration to avoid undefined variable errors

$firstname = "";
$lastname = "";
$day = "";
$month = "";
$year = "";

 
// select loggedin users details
$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
 
$user = $userRow['userName'];
 
// select contentinfo details
$gci=mysqli_query($conn,"SELECT * FROM contentinfo WHERE user='$user'");
$error = false;
	
	// POST edited file

if ( isset($_POST['btn-submit']) ) {	

	$title = trim($_POST['title']);
	$title = strip_tags($title);
	$title = htmlspecialchars($title);

	$myfile = fopen("../localStorage/$title.html", "w") or die("Unable to open file,file doesn't Exist!");
	$txt = $_POST['htmlcontent'];
	fwrite($myfile, $txt);
	fclose($myfile);
	
}

	// delete file
  
if ( isset($_POST['btn-delete']) ) {

	$title = trim($_POST['title']);
	$title = strip_tags($title);
	$title = htmlspecialchars($title);
		
	unlink ("../localStorage/$title.html");
	$delete = mysqli_query($conn,"DELETE FROM contentinfo WHERE title='$title'");
	header("Location: home.php");
}

	// save profile info
 
if ( isset($_POST['btn-save']) ) {
	
	// clean user inputs to prevent sql injections
	$firstname = trim($_POST['firstname']);
	$firstname = strip_tags($firstname);
	$firstname = htmlspecialchars($firstname);
	
	$lastname = trim($_POST['lastname']);
	$lastname = strip_tags($lastname);
	$lastname = htmlspecialchars($lastname);
	
	$day = trim($_POST['day']);
	$day = strip_tags($day);
	$day = htmlspecialchars($day);
	
	$month = trim($_POST['month']);
	$month = strip_tags($month);
	$month = htmlspecialchars($month);
	
	$year = trim($_POST['year']);
	$year = strip_tags($year);
	$year = htmlspecialchars($year);
	
	// basic name validation
	if (empty($firstname)) {
		$error = true;
		$nameError = "Please enter a first name.";
		}
  
	if (empty($lastname)) {
		$error = true;
		$nameError = "Please enter a last name.";
		}
	
	if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
		$error = true;
		$nameError = "First name must contain alphabets and space.";
		}
	
	if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
		$error = true;
		$nameError = "Last name must contain alphabets and space.";
		}
	
	// basic DOB validation
	if (!preg_match("/^[0-9]+$/",$day)) {
		$error = true;
		$nameError = "Date of birth must contain numbers only.";
		}
		
	if (!preg_match("/^[0-9]+$/",$month)) {
		$error = true;
		$nameError = "Date of birth must contain numbers only.";
		}
		
	if (!preg_match("/^[0-9]+$/",$year)) {
		$error = true;
		$nameError = "Date of birth must contain numbers only.";
		}
		
	if (!is_numeric($day)){
		$error = true;
		$nameError = "Date of birth cannot be empty and you can only use numbers.";	
		}
	
	else if (!is_numeric($month)){
		$error = true;
		$nameError = "Date of birth cannot be empty and you can only use numbers.";	
		}
	
	else if (!is_numeric($year)){
		$error = true;
		$nameError = "Date of birth cannot be empty and you can only use numbers.";	
		}
							
	else if (!checkdate($month,$day,$year)){		
		$error = true;
		$nameError = "Invalid Date of birth.";	
		} 

	// if there's no error continue to querry.			
	if( !$error ) {
					
	$combine = array($year,$month,$day);
	$fullDate = implode("-", $combine);	
	  
	$query = "UPDATE users SET firstName = '$firstname', lastName = '$lastname', bornDate = '$fullDate' WHERE userId =" .$_SESSION['user'];
	$resx = mysqli_query($conn,$query);
		
	 if ($resx) {
		$errTyp = "success";
		$errMSG = "Successfully updated.";
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
	
    <title>Welcome - <?php echo $userRow['userName']; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="../css/style.css" rel="stylesheet">
	
	<!-- Font Awesome -->	
	<script src="https://use.fontawesome.com/2e0346f2d5.js"></script>
	
	<!-- AngularJS -->
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"></script>
	
	<!-- textAngular -->
	<link rel='stylesheet' href='../css/textAngular.css'>
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
<div ng-app="profileApp">
<div ng-controller="profileController">
<div class="well well-sm text-right">
	<img src="../img/dog.png"/>
	<div class="btn-group" uib-dropdown is-open="status.isopen">
		<span id="single-button" type="button" class="btn btn-primary"  uib-dropdown-toggle ng-disabled="disabled" >&nbsp;Hi' <?php echo $userRow['userName']; ?>&nbsp;</span>
		<ul class="dropdown-menu dropdown-menu-right" uib-dropdown-menu role="menu" aria-labelledby="single-button">
			<li role="menuitem"><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
			<li role="menuitem"><a href="../">Go back to Central</a></li>
		</ul>
	</div>
</div>
<div class="page-header text-center">
	<h3>Welcome to Central</h3>
	<small>User Information</small>
</div>       
<div class="row">
	<div class="col-xs-6 text-center">
		<h4>Companion</h4>
		<div class="row center">				
			<a class="thumbnail">
				<li><img id="avatar" src="../img/dog.png"/></li>
			</a>				
		</div>
		<div class="panel panel-default"> 
			<div class="panel-heading">Your Articles</div> 
			<table class="table"> 
				<thead> 
					<tr> 
						<th>#</th> 
						<th>Name of article</th> 
						<th>User</th> 
						<th>Likes</th> 
					</tr> 
				</thead> 
				<tbody> 						
						<?php
						while ($contentRow=mysqli_fetch_array($gci)) {
							$content_id = $contentRow['id'];
							$content_title = $contentRow['title'];
							$content_user = $contentRow['user'];
							$content_likes = $contentRow['likes'];
							echo 
							"<tr><th>".$content_id."</th>
							<td><a href='' ng-click=\"template='../localStorage/$content_title.html';showEditButton();selectedx('$content_id','$content_title','$content_user','$content_likes')\">".$content_title."</a></td>
							<td>".$content_user."</td>
							<td>".$content_likes."</td></tr>";
						}
						?>
				</tbody> 
			</table> 
			<nav aria-label="Page navigation">
			  <ul class="pagination">
				<li>
				  <a href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				  </a>
				</li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li>
				  <a href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				  </a>
				</li>
			  </ul>
			</nav>
		</div>
	</div>
    <div class="col-xs-6">	
		<h4 class="text-center">Edit your profile information here.</h4>
		
		<!-- Profile Info -->
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			<div class="panel panel-default">
				<div class="panel-heading">First name*</div>
				<div class="panel-body">
					<div class="input-group">
						<input type="text" name="firstname" class="form-control" placeholder="<?php echo $userRow['firstName'];?>" maxlength="35" value="<?php echo $firstname ?>" />
					</div>
				</div>
			</div>		
			<div class="panel panel-default">
				<div class="panel-heading">Last name*</div>
				<div class="panel-body">
					<div class="input-group">
						<input type="text" name="lastname" class="form-control" placeholder="<?php echo $userRow['lastName'];?>" maxlength="35" value="<?php echo $lastname ?>" />
					</div>
				</div>
			</div>		
			<div class="panel panel-default">
				<div class="panel-heading">Date of Birth*</div>
				<div class="panel-body">
					<div class="input-group">
						<div id="date2" class="datefield">
							<input id="day" name="day" type="tel" maxlength="2" placeholder="DD"  value="<?php echo $day ?>" />/
							<input id="month" name="month" type="tel" maxlength="2" placeholder="MM"  value="<?php echo $month ?>"/>/
							<input id="year" name="year" type="number" min ="1915" max="2017" maxlength="4" placeholder="YYYY"  value="<?php echo $year ?>"/>
						</div>
					</div>
					<p>Example (13/07/1995)</p>
					<p>Your date of birth: <?php echo $userRow['bornDate'];?></p>
				</div>
			</div>			
			<button type="submit" class="btn btn-block btn-primary" name="btn-save">Save</button>			
		</form>
		
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
   if ($error) {   
?>   
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-info-sign text-danger"></span> <?php echo $nameError; ?>
		</div>
<?php
   }
?>
	</div>
</div>
<div class="row" id="editMargins">
	<div class="col-xs-12">
		<table class="table" ng-show="button">
		<thead> 
			<tr> 
				<th>#</th> 
				<th>Name of article</th> 
				<th>User</th> 
				<th>Likes</th> 
			</tr> 
		</thead>
		<tbody>
			<tr>
				<th>{{ selected_id }}</th>
				<td>{{ selected_title }}</td>
				<td>{{ selected_user }}</td>
				<td>{{ selected_likes }}</td>
			</tr>
		</tbody>
		</table>
		<hr/>
		<div ng-include="template"></div>
		<button class="btn btn-block btn-primary editMargins2" ng-show="button" ng-click="showEdit()" >Edit</button>
	</div>
</div>
<div class="row" ng-show="edit">
	<div class="col-xs-12">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			<div class="panel panel-primary editMargins3">
				<div class="panel-body">
					<p>You can copy the content above and it will stay formatted.</p>
				</div>
			</div>
			<div class="panel-body">
				<div class="input-group">
					<input type="hidden" name="title" class="form-control" placeholder= "Title*" value="{{ selected_title }}" readonly />
				</div>
			</div>
			<div text-angular ng-model="htmlcontent" name="htmlcontent"></div>
			<button type="submit" class="btn btn-block btn-primary editMargins4" name="btn-submit">Save</button>
			<button type="submit" class="btn btn-block btn-danger editMargins5" name="btn-delete" onclick="return confirm('Are you sure you want to delete this article?')">Delete Article</button>
		</form>
	</div>
</div>
</div>
</div>
</div>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	
		<script src="../js/ui-bootstrap-tpls-2.2.0.min.js"></script>
		<script src="../js/app.js"></script>
 
  
</body>
</html>
<?php ob_end_flush(); ?>