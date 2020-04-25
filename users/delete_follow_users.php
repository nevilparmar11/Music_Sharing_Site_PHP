<?php
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    
	$dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
    $query1=$dbhandler->query('select * from Users');
    while($r=$query1->fetch(PDO::FETCH_ASSOC))
    {
        if ( !strcmp($_POST[$r['username']],"unfollow")  )
        {   
            // echo $r['username'],"<br>";
            $sql="delete from Follower where followee='$r[username]' and follower='$_GET[follower]'";
            $query=$dbhandler->query($sql);
        } 
    }
		
	header("Location:/users/follow_user.php?username=$_GET[follower]");
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}
?>