<?php

$host="localhost";
$username="yourusername";
$password="yourpassword";
$db_name="yourdatebase";
$tbl_name="yourtable";

mysql_connect("$host", "$username_db" , "$password_db" )or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

?>