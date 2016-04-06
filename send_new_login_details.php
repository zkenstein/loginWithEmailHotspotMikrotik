<?php

require 'db.php';

$email = $_POST['email'];
$date = date('y.m.d h:i:s');
$mac = $_POST['mac'];
$ip = $_POST['ip'];


 require_once "Mail.php";

 //Sent mail
 //-------------------------------
 $from = "Martin Slavov <m.slavov@linux-sys-adm.com>";
 $to = $email;
 $subject = "Login details for Mrtin's WiFi";
 $cc = "Martin Slavov <martin.slavov89@gmail.com>";

 $host = "ssl://mail.linux-sys-adm.com";
 $port = "465";
 $username = "yourpassword";
 $password = "yourusernmae";

 $headers1 = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject,
   'Cc' =>  $cc);
 $headers2 = array ($headers,"MIME-Version: 1.0" => "", "Content-type: text/html; charset=UTF-8" => "");
 $headers = $headers1 + $headers2;
  $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
//-------------------------------

  $connection_ssh = ssh2_connect($ipaddress_mikrotik, $port_mikrotik);
  if (ssh2_auth_password($connection_ssh, $username_mikrotik, $password_mikrotik)) 
  {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $password_for_mikrotik = substr( str_shuffle( $chars ), 0, 6 );
  $select_from_username_for_mikrotik = mysql_query("SELECT username_for_mikrotik FROM username_for_mikrotik order by id desc limit 1;"); 
  $munber_of_user_for_mikrotik = mysql_fetch_row($select_from_username_for_mikrotik);
  $username_for_mikrotik = $munber_of_user_for_mikrotik[0];
  $username_for_mikrotik ++;
  $stream = ssh2_exec($connection_ssh, "ip hotspot user add disabled=no name=$username_for_mikrotik password=$password_for_mikrotik profile=LimitQuotes server=hotspot1 limit-uptime=1d");
  $close_ssh = ssh2_exec($ssh, "quit");
  $insert_from_email_templates="INSERT INTO username_for_mikrotik ( username_for_mikrotik , password_for_mikrotik , date  ) VALUES ( '$username_for_mikrotik' , '$password_for_mikrotik' ,'$date' )";
  $insert_result=mysql_query($insert_from_email_templates);

  $message = "
<html>
<head>
</head>
<body>
Hello, 

<p>These are your Login details:</p>

<b>Username:</b>&nbsp;&nbsp;&nbsp;&nbsp;$username_for_mikrotik<br>
<b>Password:</b>&nbsp;&nbsp;&nbsp;&nbsp;$password_for_mikrotik

<p>Now you can use Martin Slavov's WiFi with one device. If you want to network with other devices
you have to repeat the same steps. If you have a question you can contact me by email.</p>
<tr>
<p>Best Regards,</p>
</tr>
</body>
</html>
";

$id = $username_for_mikrotik;
$id .=".html";
$messageid = $id;

$my_message_content = file_get_contents('signature_templates/signature.html');
$message .= $my_message_content;
file_put_contents("email_templates/$messageid", $message);
 $mail = $smtp->send($to, $headers, $message);

  } 
  else
  {
    //Sent from base themplets
  $select_from_email_templates = mysql_query("SELECT number_template FROM email_templates order by id desc limit 1;"); 
  $email_templates = mysql_fetch_row($select_from_email_templates);
  $number_email_templates = $email_templates[0];
      if ($number_email_templates > 19 )
      {
      
        $insert_one_into_email_templates="INSERT INTO email_templates ( number_template , email , date  ) VALUES ( '1' , '$email' ,'$date' )";
        $insert_result_for_email_templates=mysql_query($insert_one_into_email_templates);
        $select_1 = mysql_query("SELECT number_template FROM email_templates order by id desc limit 1;"); 
        $email_templates_1 = mysql_fetch_row($select_1);
        $number_email_templates_new = $email_templates_1[0];
        $number_email_templates = $number_email_templates_new;
      }
  $id = $number_email_templates;
  $id .=".html";
  $messageid = $id;
  $my_message_content = file_get_contents('signature_templates/signature.html');
  $my_email_content = file_get_contents("email_templates/$messageid");
  $message = $my_email_content;
  $message .= $my_message_content;
  $mail = $smtp->send($to, $headers, $message);
  $number_email_templates = $number_email_templates + 1;

  $insert_from_email_templates="INSERT INTO email_templates ( number_template , email , date  ) VALUES ( '$number_email_templates' , '$email' ,'$date' )";
  $insert_result=mysql_query($insert_from_email_templates);

  }
   
$query2 = mysql_query("SELECT * FROM hotspot WHERE email = '". $email ."'"); 
if (mysql_num_rows($query2) > 0) 
{ 
         
}
else 
{

    $sql1="INSERT INTO hotspot ( email , date , mac ) VALUES ( '$email' , '$date' , '$mac' )";

    $result=mysql_query($sql1);

}
  
  header("Location: http://10.10.10.1/login.html");

  mysql_close($mysql_connect);

?> 