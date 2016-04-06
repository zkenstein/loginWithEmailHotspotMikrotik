<?php

//connect to database
require 'db.php';

$email = $_POST['email'];

$result = mysql_query("SELECT * FROM hotspot WHERE  
  email = '". $email ."'");

if(mysql_num_rows($result)>0){
	echo '<font color="red">The Email <STRONG>'.$username.'</STRONG> is already in use.</font>';
}else{
		echo 'OK';
}

mysql_close($mysql_connect);

?>