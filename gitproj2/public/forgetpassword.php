<?php
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
	$UM=new UserManager();
	$existuser=$UM->getUserByEmail($email);
	if(isset($existuser)){
			//generate new password
			$newpassword=$UM->randomPassword(8,1,"lower_case,upper_case,numbers");
			//update database with new password
			$UM->updatePassword($email,md5($newpassword[0]));  
			//To do: coding for sending email
			// do work here
			require_once '../phpmailer/PHPMailerAutoload.php';
			
			/* PHPMailer object */
			$mail = new PHPMailer();
			 
			/* Sender (name is optional) */
			$mail->setFrom('lithanm6@gmail.com', 'Admin');
			 
			/* Recipient (name is optional) */
			$mail->addAddress($email, 'User1');
			 
			/* Subject */
			$mail->Subject = 'Your New Password';

			/* Reply-to address */
			//$mail->addReplyTo('vader@empire.com', 'Lord Vader');

			/* CC */
			//$mail->addCC('admiral@empire.com', 'Fleet Admiral');

			/* BCC */
			//$mail->addBCC('luke@rebels.com', 'Luke Skywalker');

			/* Send message as HTML */ 
			$mail->isHTML(TRUE);

			/* Message body */
			$mail->Body = '<html>New password is '.$newpassword[0].'</html>';

			/* Plain text alternative */
			$mail->AltBody = 'There is a great disturbance in the Force.';

			/* Attachment */ 
			//$mail->addAttachment('/home/darth/star_wars.mp3', 'Star_Wars_music.mp3'); 

			/* Binary stream from a database blob field */
			//$mysql_data = $mysql_row['blob_data'];
			//$mail->addStringAttachment($mysql_data, 'db_data.db');
			 
			/* Binary network stream */
			//$pdf_url = 'http://remote-server.com/file.pdf';
			//$mail->addStringAttachment(file_get_contents($pdf_url), 'file.pdf');

			/* Use a custom SMTP server */
			$mail->isSMTP();
			 
			/* SMTP host */
			$mail->Host = 'smtp.gmail.com';
			 
			/* SMTP TCP port */
			$mail->Port = 465;
			 
			/* Use TSL secure connection */
			$mail->SMTPSecure = 'ssl';
			 
			/* Enable authentication */
			$mail->SMTPAuth = TRUE;
			 
			/* SMTP username */
			$mail->Username = 'lithanlithan8@gmail.com';
			 
			/* SMTP password */
			$mail->Password = 'H245hyt12';

			/* Send the message */
			if (!$mail->send())
			{
				echo "Error: " . $mail->ErrorInfo;
			}
			else
			{
				echo "Message sent.";
			}
			
			$formerror="New password have been sent to ".$email;
			//header("Location:home.php");
	}else{
			$formerror="Invalid email user";
	}
}

?>
<html>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
<body>

<h1>Forget Password</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table border='0' width="100%">
  <tr>    
    <td>Email</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}"   required title="Cannot be empty field" size="30"></td>
	<td><?php echo $error_name?>
  </tr> 
  <tr>
    <td></td>
    <td><br><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
    </td>
  </tr>
  <tr><p style="color:red;"> <?php echo $formerror?></p></tr>
</table>
</form>
<?php
include 'includes/footer.php';
?>