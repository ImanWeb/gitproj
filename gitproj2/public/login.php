<?php
session_start();
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
include 'includes/header.php';
$formerror="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
    //$password=$_POST["password"];
	$password=md5($_POST["password"]);
	$response = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LfBZYIUAAAAAH5nbZwmb-4QhB9znTut1bPVrZ3n',
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array ('method' => 'POST', 'content' => http_build_query($data))
	);
	$context = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
	if ($captcha_success->success==false) {
		echo "<p>You are a bot! Go away!</p>";
	} else if ($captcha_success->success==true)
	{
		$UM=new UserManager();
		$existuser=$UM->getUserByEmailPassword($email,$password);
		if(isset($existuser)){
			$_SESSION['email']=$email;
			$_SESSION['id']=$existuser->id;
			$_SESSION['role']=$existuser->role;
			echo '<meta http-equiv="Refresh" content="1; url=home.php">';
		} else{
			$formerror="Invalid User Name or Password";
		}
	}
	//To do: make changes to compare hash password instead
	//if($validate->check_password($password, $error_passwd))
	{
		$UM=new UserManager();

		$existuser=$UM->getUserByEmailPassword($email,$password);
		if(isset($existuser)){
			
			$_SESSION['email']=$email;
			$_SESSION['id']=$existuser->id;
			$_SESSION['role']=$existuser->role;
			echo '<meta http-equiv="Refresh" content="1; url=home.php">';
		}else{
			$formerror="Invalid User Name or Password";
		}
	}
}

?>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
<h1>Login</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table border='0' width="100%">
  <tr>    
    <td>Email</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}"   required title="Cannot be empty field" size="30"></td>
	<td><?php echo $error_name?>
  </tr>
  <tr>    
    <td>Password</td>
    <td><input type="password" name="password" value="<?=$password?>"  size="30"></td>
	<td><?php echo $error_passwd?>
  </tr> 
  <!-- To do : add recaptcha here  -->
  <tr>
    <td></td>
    <td><br><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
    <input type="reset" name="reset" value="Reset" class="pure-button pure-button-primary"></td>
    </td>
  </tr>
  <tr> <?php echo $formerror?></tr>
  <tr>
  <td></td>
    <td>
       <br><a class="pure-button" href="modules/user/register.php">Register Now</a>
	   <a class="pure-button" href="./forgetpassword.php">Forget Password</a>
    </td>
  </tr>   
</table><div class="g-recaptcha" data-sitekey="6LfBZYIUAAAAAFWAbZlZKtv5BJeu1aSPHFrCvgLi"></div>
</form>
<?php
include 'includes/footer.php';
?>