<?php

//connect to database
require 'db.php';

$username = $_POST['username'];
$passowrd = $_POST['passowrd'];

$result = mysql_query("SELECT * FROM username_for_mikrotik WHERE  
  username_for_mikrotik = '". $username ."'") ;

$result1 = mysql_query("SELECT * FROM hotspot WHERE  
  username = '". $username ."'");

if((mysql_num_rows($result)>0) AND (mysql_num_rows($result)>0)){
	echo '<font color="red">The username <STRONG>'.$username.'</STRONG> is wrong in use.</font>';
}
else
{
	echo 'OK';
}

mysql_close($mysql_connect);

?>