<?php

//load details for databse connection
require 'db.php';

//get details from mikrotik
$dates = date('y.m.d h:i:s');
$mac=$_POST['mac'];
$ip = $_POST['ip'];

if (get_magic_quotes_gpc())
{ 
 
    $email = stripslashes($email);
}

$email = mysql_real_escape_string($email);




$query_check_dubliacted_mac = mysql_query("SELECT * FROM hotspot WHERE mac = '". $mac ."'"); 
if (mysql_num_rows($query_check_dubliacted_mac) > 0) 
{ 
        header("Location: http://hotspot.tk/login.php?mac=$mac");
}

elseif ($mac)
{
 	?>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/style.css">

  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../script.js"></script>


  <link rel="stylesheet" type="text/css" href="bootstrap.css">
  
  <script type="text/javascript" src="../js/jquery-1.2.6.min.js"></script>
<script type="text/javascript">

pic1 = new Image(16, 16); 
pic1.src = "loader.gif";


$(document).ready(function(){

$("#email").change(function() { 

var usr = $("#email").val();

$("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');

    $.ajax({  
    type: "POST",  
    url: "check_dublicated_email.php",  
    data: "email="+ usr,  
    success: function(msg){  
   
   $("#status").ajaxComplete(function(event, request, settings){ 
  if(msg == 'OK')
  { 
    $("#email").removeClass('object_error'); // if necessary
    $("#email").addClass("object_ok");
    $(this).html('');
    $("#submintLogin").removeAttr("disabled");
  }  
  else  
  {  
    $(this).html("<p align='center'><font face='Arial' size='5' color='#FF0000'>The <STRONG>Email</STRONG> is already in use!</font></p>");
    $("#submintLogin").attr("disabled", true);
  }  
   });
 } 
  }); 
});
});
</script>

<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    agree: "required"
                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    email: "<p align='center'><font face='Arial' size='5' color='#FF0000'>Please enter a valid email</font></p>",
                    
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>

       <html>
        </head>
          <body>
            <form action="signin.php" method="post" id="register-form" name="form">
              <section class="container">
                <div class="login_get_new_login_details">
                  <h1>Martin Slavov's WiFi</h1>
                  <h2><font face='Arial' size='3' color="black">Please Fill in your <b55>E-mail</b55> to use our Free WiFi service</font></h2>
                  <a><font face='Arial' size='3' color="black">After you click submit you will receive <b55>E-mail</b55> with login details.</font></a>
                  <p><input type="email" name="email" id="email" value="" placeholder="Email"></p>
        	        <?php echo '<input name="mac" type="hidden" value="'.$mac.'"   />'; ?>
                  <?php echo '<input name="ip" type="hidden" value="'.$ip.'"   />'; ?>
                  <p id="status"></p>
                  <p class="submit"><input type="submit" id="submintLogin"name="commit" value="SUBMIT"></p>
                </div>
              </section>
            </form>
              <section class="about-author">
              <p class="about">
        	   &copy; 2016 Developed by<a href="https://www.linkedin.com/in/slavovmartin" target="_blank">  Martin Slavov</a>
              </section>
          </body>
        </html>
  
  <?php
}
else
{
header("Location: http://10.10.10.1/login.html");
} 

mysql_close($mysql_connect);
?>