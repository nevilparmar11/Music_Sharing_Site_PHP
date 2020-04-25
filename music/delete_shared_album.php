<?php
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    
	$dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	if( $_POST[submit]=="Unshare")
	{
		echo "yes";
		$query1=$dbhandler->query('select * from Shared_Albums');
		while($r=$query1->fetch(PDO::FETCH_ASSOC))
		{
			if ( !strcmp($_POST[$r['Reciever']],"unshare")  )
			{   
				// echo $r['Reciever']," ",$_GET['album'],"<br>";
				$sql="delete from Shared_Albums where album_title='$_GET[album]' and Reciever='$r[Reciever]'";
				$query=$dbhandler->query($sql);
			} 
		}
		header("Location:/music/all_users.php?username=$_GET[username]&album=$_GET[album]");
	}

	else 
	{	
		$sql="delete from Shared_Albums where album_title='$_GET[album]' and Reciever='$_GET[reciever]'";
    	$query=$dbhandler->query($sql);
		header("Location:/music/albums.php?username=$_GET[username]");
	}	

}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}
?>