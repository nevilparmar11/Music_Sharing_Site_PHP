<?php
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql="delete from Albums where album_title='$_GET[album]' and username='$_GET[username]'";
    $query=$dbhandler->query($sql);
    $sql="delete from Songs where album_title='$_GET[album]'";
    $query=$dbhandler->query($sql);
    // echo $_GET['album']," ",$_GET['username'];
    header("Location:/music/albums.php?username=$_GET[username]");
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}
?>