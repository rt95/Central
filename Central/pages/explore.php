<?php
ob_start();
session_start();
require_once '../php/dbconnect.php';

// variable declaration to avoid undefined variable errors

$comment = "";
$error = "";

// select contentinfo details
$gci=mysqli_query($conn,"SELECT * FROM contentinfo");

// if session is set let user comment else don't
if( isset($_SESSION['user']) ) {
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysqli_fetch_array($res);
	$user = $userRow['userName'];
	
	//cant comment if not logged in
	if ( isset($_POST['btn-comment']) ) {
		
		// clean user inputs to prevent sql injections
		$article_id = trim($_POST['article_id']);
		$article_id = strip_tags($article_id);
		$article_id = htmlspecialchars($article_id);
		
		$comment = trim($_POST['comment']);
		$comment = strip_tags($comment);
		$comment = htmlspecialchars($comment);
		
		$query = "INSERT INTO commentsinfo(articleId,user,comment) VALUES('$article_id','$user','$comment')";
		$resx = mysqli_query($conn,$query);
		
		header("Location: ../#/explore");
	}	
	
	//cant delete comment if not logged in	
	if ( isset($_POST['btn-delete-comment']) ) {
		
	$userConfirm = trim($_POST['userConfirm']);
	$userConfirm = strip_tags($userConfirm);
	$userConfirm = htmlspecialchars($userConfirm);
	
		if ($userConfirm == $user ){
			$userComment = trim($_POST['userComment']);
			$userComment = strip_tags($userComment);
			$userComment = htmlspecialchars($userComment);
		
			$delete = mysqli_query($conn,"DELETE FROM commentsinfo WHERE comment='$userComment'");
			header("Location: ../#/explore");
			
		}
		
		else {
			// zavrsi ovo 
			echo $error = "You're not the owner of the comment you silly!";
			header("Location: ../index.php");
		}
	}
}

else { ?>
	<style type="text/css"> 
	.commentform{
		display:none;
		}
	</style>
<?php
}

?>
<div class="panel panel-default" ng-hide="value"> 
	<div class="panel-heading">{{ message }}</div> 
	<div class="panel-body"> 
		<p>Here you will find all the articles on the website.</p> 	
	</div> 
</div>
<table class="table" ng-hide="value"> 
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
				<td><a href='' ng-click=\"template='localStorage/$content_title.html';hideTbl();selectedx('$content_id','$content_title','$content_user','$content_likes')\">".$content_title."</a></td>
				<td>".$content_user."</td>
				<td>".$content_likes."</td></tr>";
				}
			?>
	</tbody> 
</table>	
<table class="table" ng-show="value">
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
<div class="text-right">
	<button type="button" class="btn btn-primary" ng-show="value" ng-click="reloadPage()">Back to exploring!</button>
</div>
<hr/>
<div ng-include="template"></div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
<div class="panel panel-default">
<div class="panel-body" ng-show="value"> 
<table class="table special">
	<tr>
		<th>User</th>
		<th>Comment</th>
	</tr>
	<tr ng-repeat="individual in data"> 
		<div ng-repeat="x in individual track by $index">
			<td>{{ individual.user }} <input type="checkbox" ng-hide="value" ng-checked="master" name="userConfirm" class="form-control commentform" value="{{ individual.user }}" /></td>
			<td ng-click="show_send($parent,$index)">{{ individual.comment }}<br/><label class="commentform" ng-show="toggle && $parent.selectedIndex == $index">Delete Comment <input type="checkbox" ng-click="$parent.toggle = !$parent.toggle" ng-model="master" name="userComment" class="form-control commentform" value="{{ individual.comment }}" /></label></td>
		</div>
	</tr>
</table>
	<button type="submit" ng-show="toggle" class="btn btn-block btn-danger commentform special" name="btn-delete-comment" onclick="return confirm('Are you sure you want to delete this comments?')"><span class="glyphicon glyphicon-remove"></span></button>			
</div>
</div>
</form>
<div class="panel panel-default panel-width commentform" " ng-show="value"> 
	<div class="panel-heading">Leave a comment!</div> 
	<div class="panel-body form-group"> 
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			<input type="hidden" name="article_id" class="form-control" placeholder= "id*" value="{{ selected_id }}" readonly />
			<p><?php echo $userRow['userName']; ?></p>
			<input id="comment" name="comment" type="text" class="form-control" placeholder="Type your comment here." size="35" required value="<?php echo $comment ?>"/>
			<button type="submit" class="btn btn-block btn-primary" name="btn-comment">Send</button>			
		</form>
	</div> 
</div>
<?php ob_end_flush(); ?>