
<?php
session_start();
$target_location="/music/uploads/".basename($_FILES["audio_file"]["name"]);
if(! (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $target_location)))
	echo "Error: " . $_FILES["audio_file"]["error"] . "<br>";
else
{
	$ext = pathinfo($target_location, PATHINFO_EXTENSION);
	$new="/music/uploads/".$_POST['audio_file'].".".$ext;
	rename($target_location,$new);
	header("Location:/music/songs.php?album=$_SESSION[album]&username=$_SESSION[username]");
	
}
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql="insert into Songs (album_title,song_title,audio_file) values ( '$_SESSION[album]','$_POST[song_title]','$_POST[audio_file]')";
	$query=$dbhandler->query($sql);

    header("Location:/music/songs.php?album=$_SESSION[album]&username=$_SESSION[username]");

	
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}


	
?>
