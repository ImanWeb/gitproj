<?php
session_start();
session_destroy();
header("Location:/phpcrudsample/public/login.php");
?>