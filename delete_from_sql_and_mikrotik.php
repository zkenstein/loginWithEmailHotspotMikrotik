<?php

//connect to database
require 'db.php';

$ipaddress_mikrotik = "ipaddress";
$port_mikrotik = "ipaddress";
$username_mikrotik = "yourusername";
$password_mikrotik = "yourpassword";

$select_record_older_than_7_days = mysql_query("SELECT username_for_mikrotik FROM username_for_mikrotik 
					WHERE date < DATE_SUB(NOW(), INTERVAL 7 DAY)"); 

if (mysql_num_rows($select_record_older_than_7_days) > 0) 
{
 	 $connection_ssh = ssh2_connect($ipaddress_mikrotik, $port_mikrotik);
	 ssh2_auth_password($connection_ssh, $username_mikrotik, $password_mikrotik);

	while($row = mysql_fetch_array($select_record_older_than_7_days))
  	{
 	
 	 	$username_for_delete = $row['username_for_mikrotik'];
 	 	
 		$stream = ssh2_exec($connection_ssh, "ip hotspot user remove $username_for_delete");

		$insert_null=mysql_query("UPDATE hotspot SET  username = '', 
     									 password = '' WHERE username ='$username_for_delete'");
		
 	}
  $close_ssh = ssh2_exec($ssh, "quit");

  $delete_record_older_than_7_days = mysql_query("DELETE FROM username_for_mikrotik WHERE date < DATE_SUB(NOW(), INTERVAL 7 DAY)");
}

mysql_close($mysql_connect);

?> 