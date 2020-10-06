<?php
session_start();
require_once '../php/dbconnect.php';

$request = json_decode( file_get_contents('php://input') );
$variable = $request->data;
$_SESSION['selected'] = $variable;

if(isset($_SESSION['selected'])){
	$gci=mysqli_query($conn,"SELECT * FROM commentsinfo WHERE articleId=".$_SESSION["selected"]);	
	
	$data = array();
	
	while ($commentsRow=mysqli_fetch_array($gci)) {
		
	$user = $commentsRow['user'];
	$comment = $commentsRow['comment'];
	$id = $commentsRow['commentId'];
	
	$data[] = array(
	"user" => $user,
	"comment" => $comment,
	"sucess" => true
	);

 }
 echo json_encode ($data,JSON_FORCE_OBJECT);
	

	
};
?>
