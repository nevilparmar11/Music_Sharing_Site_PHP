<?php
session_start();
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
	echo "Connection is established...<br/>";
	$dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql="insert into Users (First_name,Last_name,username,password,email) values ( '$_POST[First_name]','$_POST[Last_name]','$_POST[username]','$_POST[password]','$_POST[email]')";
	$query=$dbhandler->query($sql);
	$_SESSION['username'] = $_POST['username'];
	header("Location:/music/albums.php?username=$_POST[username]");
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}


?>