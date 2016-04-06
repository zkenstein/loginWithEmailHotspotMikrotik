<?php

$ipaddress_mikrotik = "ipaddress";
$port_mikrotik = "ipaddress";
$username_mikrotik = "yourusername";
$password_mikrotik = "yourpassword";

require 'db.php';

$promocode = $_POST['promocode'];
$mac = $_POST['mac'];
$username = $_POST['username'];
$password = $_POST['password'];

$query_select_hotspot_check_username = mysql_query("SELECT * FROM hotspot WHERE username = '". $username ."' AND 
  password = '". $password ."'"); 

$select_from_username_for_mikrotik = mysql_query("SELECT * FROM username_for_mikrotik WHERE  
  username_for_mikrotik = '". $username ."' AND 
  password_for_mikrotik = '". $password ."'"); 

$query_select_username_hotspot = mysql_query("SELECT * FROM username WHERE  
  username = '". $username ."' AND 
  password = '". $password ."'"); 

$query_select_hotspot = mysql_query("SELECT * FROM hotspot WHERE mac = '". $mac ."' AND 
  username = '". $username ."' AND 
  password = '". $password ."'"); 

if (mysql_num_rows($query_select_hotspot) > 0) 
{ 
  
  $result = mysql_query("SELECT mac , username , password FROM hotspot WHERE mac = '". $mac ."'");
  $row = mysql_fetch_row($result);
  $mac1 = $row[0];
  $username1 = $row[1];
  $password1 = $row[2];

  header("location: http://10.10.10.1/login?username=$username1&password=$password1");
  
}
elseif((mysql_num_rows($select_from_username_for_mikrotik) > 0) AND (mysql_num_rows($query_select_hotspot_check_username) > 0))
{
  //echo "Username and password already used from other device!";
          ?>
              <html>
              <center><a>Username and password already used from other device!</a></center>
              <center><p><button id="myBtn">Back to Login page!</button></p></center>
              <script>
              var btn = document.getElementById('myBtn');
              btn.addEventListener('click', function() {
              document.location.href = 'http://10.10.10.1/login.html';
              });
               </script>
              </html>
          <?php
}
elseif (mysql_num_rows($query_select_username_hotspot) > 0) 
{

    if ($promocode != "")
    {
            $select_promocode_middlespeed = mysql_query("SELECT * FROM promocode_middlespeed WHERE promocode = '". $promocode ."'");
            $select_promocode_highspeed = mysql_query("SELECT * FROM promocode_highspeed WHERE promocode = '". $promocode ."'"); 
            if (mysql_num_rows($select_promocode_highspeed) > 0) 
             {
                      header("location: http://10.10.10.1/login?username=$username&password=$password");
             }
             elseif (mysql_num_rows($select_promocode_middlespeed) > 0) 
             {
                      header("location: http://10.10.10.1/login?username=$username&password=$password");
             }
             else
             {

                   ?>
                         <html>
                        <center><a>Promocode is incorrect !</a></center>
                        <center><p><button id="myBtn">Back to Login page!</button></p></center>
                         <script>
                           var btn = document.getElementById('myBtn');
                        btn.addEventListener('click', function() {
                         document.location.href = 'http://10.10.10.1/login.html';
                             });
                        </script>
                        </html>
                    <?php
              }
      }        
      else
      {
            //insert into table hotspot against mac after that redirect
           $insert_username_and_password="UPDATE hotspot SET  username = '$username', 
             password = '$password' WHERE mac ='$mac'";
           $result_insert_username_and_password=mysql_query($insert_username_and_password);
           header("location: http://10.10.10.1/login?username=$username&password=$password");

      }

}
elseif (mysql_num_rows($select_from_username_for_mikrotik) > 0)
{

    if ($promocode != "")
    {
            $select_promocode_middlespeed = mysql_query("SELECT * FROM promocode_middlespeed WHERE promocode = '". $promocode ."'");
            $select_promocode_highspeed = mysql_query("SELECT * FROM promocode_highspeed WHERE promocode = '". $promocode ."'"); 
            if (mysql_num_rows($select_promocode_highspeed) > 0) 
             {
                  //"highspeed";
                      $connection_ssh = ssh2_connect( $ipaddress_mikrotik, $port_mikrotik);
                      ssh2_auth_password($connection_ssh,  $username_mikrotik, $password_mikrotik);
                      $stream = ssh2_exec($connection_ssh, "ip hotspot user set $username profile=HighQuotes");
                      $close_ssh = ssh2_exec($ssh, "quit");

                      $insert_username_and_password_1="UPDATE hotspot SET  username = '$username', 
                                                                           password = '$password' WHERE mac ='$mac'";
                      $result_insert_username_and_password=mysql_query($insert_username_and_password_1);
                      header("location: http://10.10.10.1/login?username=$username&password=$password");
             }
             elseif (mysql_num_rows($select_promocode_middlespeed) > 0) 
             {
                    //"middlesspeed";
                      $connection_ssh = ssh2_connect( $ipaddress_mikrotik, $port_mikrotik);
                      ssh2_auth_password($connection_ssh,  $username_mikrotik, $password_mikrotik);
                      $stream = ssh2_exec($connection_ssh, "ip hotspot user set $username profile=MiddleQuotes");
                      $close_ssh = ssh2_exec($ssh, "quit");

                      $insert_username_and_password_1="UPDATE hotspot SET  username = '$username', 
                                                                           password = '$password' WHERE mac ='$mac'";
                      $result_insert_username_and_password=mysql_query($insert_username_and_password_1);
                      header("location: http://10.10.10.1/login?username=$username&password=$password");
             }
             else
             {

                   ?>
                         <html>
                        <center><a>Promocode is incorrect !</a></center>
                        <center><p><button id="myBtn">Back to Login page!</button></p></center>
                         <script>
                           var btn = document.getElementById('myBtn');
                        btn.addEventListener('click', function() {
                         document.location.href = 'http://10.10.10.1/login.html';
                             });
                        </script>
                        </html>
                    <?php
              }
      }        
      else
      {
        
      //insert into table hotspot against mac after that redirect
      $insert_username_and_password_1="UPDATE hotspot SET  username = '$username', 
      password = '$password' WHERE mac ='$mac'";
      $result_insert_username_and_password=mysql_query($insert_username_and_password_1);
      header("location: http://10.10.10.1/login?username=$username&password=$password");
      }

}
else
{

      ?>
<html>
<center><a>Username or Password is incorrect !</a></center>
<center><p><button id="myBtn">Back to Login page!</button></p></center>
<script>
var btn = document.getElementById('myBtn');
btn.addEventListener('click', function() {
  document.location.href = 'http://10.10.10.1/login.html';
});
 </script>
</html>
    <?php

}
mysql_close();

?>

