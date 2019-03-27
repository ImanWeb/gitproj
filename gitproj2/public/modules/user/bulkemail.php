<?php
session_start();
use classes\business\UserManager;
use classes\entity\User;
use classes\business\Validation;

require_once '../../includes/autoload.php';
include '../../includes/header.php';
$formerror="";

$email="";
$subject="";
$message="";
$error_auth="";
$error_name="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
	$message=$_POST["message"];
	$subject=$_POST["subject"];
	require_once '../../../phpmailer/PHPMailerAutoload.php';
	
	/* PHPMailer object */
	$mail = new PHPMailer();
	 
	/* Sender (name is optional) */
	$mail->setFrom('lithanm6@gmail.com', 'Admin');
	 
	/* Recipients (name is optional) */
	$recipients = explode(',',$email);
	foreach ($recipients as $recipient){
		$mail->addAddress($recipient);
	}
	 
	/* Subject */
	$mail->Subject = $subject;

	/* Send message as HTML */ 
	$mail->isHTML(TRUE);

	/* Message body */
	$mail->Body = $message;

	/* Plain text alternative */
	$mail->AltBody = $message;

	/* Attachment */ 
	//$mail->addAttachment('/home/darth/star_wars.mp3', 'Star_Wars_music.mp3'); 

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
					
}

if(isset($_POST["submitted2"])){
    //$email=$_POST["email"];
	$message=$_POST["message"];
	$subject=$_POST["subject"];
	$UM=new UserManager();
	$users=$UM->getAllUsers();
	foreach($users as $user){
		if($user && $user->subbed == '1'){
			require_once '../../../phpmailer/PHPMailerAutoload.php';
			
			/* PHPMailer object */
			$mail = new PHPMailer();
			 
			/* Sender (name is optional) */
			$mail->setFrom('lithanm6@gmail.com', 'Admin');
			
			/* Recipients (name is optional) */
			$mail->addAddress($user->email);
			 
			/* Subject */
			$mail->Subject = $subject;

			/* Send message as HTML */ 
			$mail->isHTML(TRUE);

			/* Message body */
			$mail->Body = $message;

			/* Plain text alternative */
			$mail->AltBody = $message;

			/* Attachment */ 
			//$mail->addAttachment('/home/darth/star_wars.mp3', 'Star_Wars_music.mp3'); 

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
				//echo "Message sent.";
			}			
		}
	}
	echo "Message sent.";
}

?>
<html>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<style scoped>
.button-success {
	color: white;
	background: rgb(28, 184, 65); <!-- this is a green -->
}

.button-error {
	color: white;
	background: rgb(202, 60, 60); <!-- this is a maroon -->
}
</style>
<body>

<h1>Bulk Email</h1>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table border='0' width="100%">
  <tr>  
    <td><br>Recipients</td>
    <td><br><input type="text" name="email" value="<?=$email?>"</td>
  </tr>
  <tr>    
	<td><br>Subject</td>
    <td><br><input type="text" name="subject""</td>
  </tr>
  <tr>
	<td><br>Message</td>
    <td><br><textarea name="message" rows = "7" cols = "50"></textarea></td>
  </tr> 
  <tr>
    <td></td>
	<td><br><input type="submit" name="submitted2" value="Send to subscribers" class="button-success pure-button">
    <input type="submit" name="submitted" value="Send to recipients" class="pure-button pure-button-primary">
	<input type="reset" name="reset" value="Reset" class="button-error pure-button">
    </td>
  </tr>
  <tr><p style="color:red;"> <?php echo $formerror?></p></tr>
</table>
</form>
<?php
include '../../includes/footer.php';
?>