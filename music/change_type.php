<?php
session_start();
if( !isset($_SESSION['username']) )
    header("Location:/users/login.php");
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
    $query1=$dbhandler->query('select * from Albums');
    while($r=$query1->fetch(PDO::FETCH_ASSOC))
    {
        if ( $r['album_title']==$_GET['album']  )
        {   
            // echo $r[album_title],' ',$r[is_private];
            if ($r[is_private]==1)
            {
                $sql="UPDATE Albums SET is_private=0 WHERE album_title='$_GET[album]' ";
                $query=$dbhandler->query($sql);
            }
            else if ($r[is_private]==0)
            {
                $sql="UPDATE Albums SET is_private=1 WHERE album_title='$_GET[album]' ";
                $query=$dbhandler->query($sql);
            }
        } 
    }
    header("Location:/music/albums.php?username=$_GET[username]");    
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}

?>