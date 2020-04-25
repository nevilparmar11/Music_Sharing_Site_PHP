<?php
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql="delete from Songs where song_title='$_GET[song_title]' and album_title='$_GET[album]'";
    $query=$dbhandler->query($sql);
    header("Location:/music/songs.php?album=$_GET[album]&username=$_GET[username]");
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}
?>