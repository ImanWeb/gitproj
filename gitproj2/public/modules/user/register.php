<?php
require_once '../../includes/autoload.php';
include '../../includes/header.php';
use classes\util\DBUtil;
use classes\business\UserManager;
use classes\entity\User;

$formerror="";

$firstName="";
$lastName="";
$email="";
$password="";

if(isset($_REQUEST["submitted"])){
    $firstName=$_REQUEST["firstName"];
    $lastName=$_REQUEST["lastName"];
    $email=$_REQUEST["email"];
    //$password=$_REQUEST["password"];
	$password=md5($_REQUEST["password"]);
    
    if($firstName!='' && $lastName!='' && $email!='' && $password!=''){
        $UM=new UserManager();
        $user=new User();
        $user->firstName=$firstName;
        $user->lastName=$lastName;
        $user->email=$email;
        $user->password=$password;
        $user->role="user";
		$user->subbed="1";
        $existuser=$UM->getUserByEmail($email);
		//to do: check password strength, reject if weak
		
		//to do: save salted hash password into database

        if(!isset($existuser)){
            // Save the Data to Database
            $UM->saveUser($user);
            #header("Location:registerthankyou.php");
			echo '<meta http-equiv="Refresh" content="1; url=./registerthankyou.php">';
        }
        else{
            $formerror="User Already Exist";
        }
    }else{
        $formerror="Please fill in the fields";
    }
}
?>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<h1>Registration Form</h1>
<div><?=$formerror?></div>
<table width="800">
  <tr>
    <td>First Name</td>
    <td><input type="text" name="firstName" value="<?=$firstName?>" size="50"></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type="text" name="lastName" value="<?=$lastName?>" size="50"></td>
  </tr>
  <tr>    
    <td>Email</td>
    <td><input type="text" name="email" value="<?=$email?>" size="50"></td>
  </tr>
  <tr>    
    <td>Password</td>
    <td><input type="password" name="password" value="<?=$password?>" size="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
	onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters' : ''); if(this.checkValidity()) form.cpassword.pattern = this.value;"></td>
  </tr>  
  <tr>    
    <td>Confirm Password</td>
    <td><input type="password" name="cpassword" value="<?=$password?>" size="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
	onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');"></td>
  </tr>  
  <tr>
   <br> <td>
       <input type="submit" name="submitted" value="Submit">
       <input type="reset" name="reset" value="Reset">
    </td>
  </tr>
</table>
</form>

<?php
include '../../includes/footer.php';
?>