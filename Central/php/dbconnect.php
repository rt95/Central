<?php
 
define('DBHOST', '127.0.0.1');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'centraldb');
 
$conn = mysqli_connect(DBHOST,DBUSER,DBPASS);

if ( !$conn ) {
	die("Connection failed : " . mysqli_error());
}
 
$dbcon = mysqli_select_db($conn,DBNAME);
 
 if ( !$dbcon ) {
	die("Database Connection failed : " . mysqli_error());
}

?>