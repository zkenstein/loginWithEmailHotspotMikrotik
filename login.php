<?php

require 'db.php';

$dates = date('y.m.d h:i:s');
$mac = $_GET['mac'];

if (empty($mac))
{
   header("Location: http://10.10.10.1/login.html");
}
  $result_new = mysql_query("SELECT mac , username , password FROM hotspot WHERE mac = '". $mac ."'");
  $row = mysql_fetch_row($result_new);
  $mac1 = $row[0];
  $username1 = $row[1];
  $password1 = $row[2];
if (($username1 != NULL) && ($password1 != NULL) && ($mac1 != NULL)) 
{
header("location: http://10.10.10.1/login?username=$username1&password=$password1");
}
?>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../script.js"></script>
  <link rel="stylesheet" type="text/css" href="bootstrap.css">

  <script type="text/javascript">

function ValidateContactForm()
{

    document.getElementById('status').innerHTML="";
    document.getElementById('UsernameOrPasswordIsIncorrect').innerHTML="";
    document.getElementById('PromocodeIsWrong').innerHTML="";

    var username = document.ContactForm.username;
    var password = document.ContactForm.password;
    var email = document.ContactForm.Email;
    var promocode = document.ContactForm.promocode;
    var email = document.ContactForm.password;
    var phone = document.ContactForm.Telephone;
    var nocall = document.ContactForm.DoNotCall;
    var what = document.ContactForm.Subject;
    var comment = document.ContactForm.Comment;

    if ((username.value == "") || (password.value == ""))
    {
        document.getElementById('status').innerHTML="<a align='center'><font face='Arial' size='3' color='#FF0000'>Username or password missing!</font></a>";
        return false;
    }
       if ((promocode.value == "") || (promocode.value == "martinslavov")
                                || (promocode.value == "martinslavov1")
                                || (promocode.value == "martinslavov2")
                                || (promocode.value == "martinslavov3")
                                || (promocode.value == "martinslavov4")
                                || (promocode.value == "martinslavov5")
                                || (promocode.value == "slavovmartin")
                                || (promocode.value == "slavovmartin1")
                                || (promocode.value == "slavovmartin2")
                                || (promocode.value == "slavovmartin3")
                                || (promocode.value == "slavovmartin4")
                                || (promocode.value == "slavovmartin5"))
   {
     return true;
   }
     document.getElementById('PromocodeIsWrong').innerHTML="<a align='center'><font face='Arial' size='3' color='#FF0000'>Promo code is wrong!</font></a>";
     return false;
}

function EnableDisable(chkbx)
{
    if(chkbx.checked == true)
    {
        document.ContactForm.Telephone.disabled = true;
    }
    else
    {
        document.ContactForm.Telephone.disabled = false;
    }
}
</script>

<script type="text/javascript">

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidationGetNewLoginDetails: function()
        {
            //form validation rules
            $("#get_new_login_details").validate({
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
        JQUERY4U.UTIL.setupFormValidationGetNewLoginDetails();
    });

})(jQuery, window, document);
</script>


<script type="text/javascript" src="../js/jquery-1.2.6.min.js"></script>
<script type="text/javascript">

pic1 = new Image(16, 16); 
pic1.src = "loader.gif";

$(document).ready(function(){

$("#username").change(function() { 

    document.getElementById('UsernameOrPasswordMissing').innerHTML="";
    document.getElementById('UsernameOrPasswordIsIncorrect').innerHTML="";
    document.getElementById('PromocodeIsWrong').innerHTML="";
    var usr = $("#username").val();

$("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');
    $.ajax({  
    type: "POST",  
    url: "check_dublicated_username.php",  
    data: "username="+ usr,  
    success: function(msg){  
   $("#status").ajaxComplete(function(event, request, settings){ 
  if(msg == 'OK')
  { 
    $("#username").removeClass('object_error'); // if necessary
    $("#username").addClass("object_ok");
    $(this).html('');
    $("#submintLogin").removeAttr("disabled");
  }  
  else  
  {  
    $(this).html("<a align='center'><font face='Arial' size='3' color='#FF0000'>The <STRONG>username</STRONG> is already in use.</font></a>");
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
        setupFormValidationGetNewLoginDetails: function()
        {
            //form validation rules
            $("#get_new_login_details").validate({
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
        JQUERY4U.UTIL.setupFormValidationGetNewLoginDetails();
    });

})(jQuery, window, document);
</script>

<html>
  </head>
    <body>
      <section class="container">
        <div class="login">
          <form action="signin_for_login_form.php" method="post" id="register-form" name="ContactForm" onsubmit="return ValidateContactForm();"> 
            <h1>Martin Slavov's WiFi</h1>
            <h2>Please Fill in your details to use our Free WiFi service</h2>
            <p><input type="username" name="username" id="username" value="" placeholder="username"></p>
            <p><input type="password" name="password" id="password" value="" placeholder="password"></p>
            <p><input type="promocode" name="promocode" id="promocode" value="" placeholder="promocode"></p>
            <a id="UsernameOrPasswordMissing"></a>
            <a id="UsernameOrPasswordIsIncorrect"></a>
            <a id="PromocodeIsWrong"></a>
            <p id="status"></p>
            <?php echo '<input name="mac" type="hidden" value="'.$mac.'"   />'; ?>
            <?php echo '<input name="ip" type="hidden" value="'.$ip.'"   />'; ?>
            <p class="submit"><input type="submit" id="submintLogin" name="commit" value="Login"></p>
          </form>
          <form action="send_new_login_details.php" method="post" id="get_new_login_details" name="form" > 
            <p><input type="email" name="email" id="email" value="" placeholder="email"></p>
            <?php echo '<input name="mac" type="hidden" value="'.$mac.'"   />'; ?>
            <?php echo '<input name="ip" type="hidden" value="'.$ip.'"   />'; ?>
            <p class="submit"><input type="submit" name="commit" value="Get New Login Details"></p>
          </form>
        </div>
       </section>
       <section class="about-author">
             <p class="about">
                &copy; 2016 Developed by<a href="https://www.linkedin.com/in/slavovmartin" target="_blank">  Martin Slavov</a>
             </section>
    </body>
  </html>
<?php

mysql_close($mysql_connect);

?>