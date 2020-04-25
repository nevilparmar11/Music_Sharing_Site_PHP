<?php
session_start();
if( !isset($_SESSION['username']) )
    header("Location:/users/login.php");
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');

    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	// $sql="create table Follower ( 
    //     follower VARCHAR(200) NOT NULL,
    //     followee VARCHAR(200) NOT NULL,
    //     created_at TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    //     FOREIGN KEY (follower) REFERENCES Users(username) ON DELETE CASCADE,
    //     FOREIGN KEY (followee) REFERENCES Users(username) ON DELETE CASCADE
    //     )";
	// $query=$dbhandler->query($sql);
    // echo "Table is created successfully";

    $query1=$dbhandler->query('select * from Users');
    while($r=$query1->fetch(PDO::FETCH_ASSOC))
    {
        if ( !strcmp($_POST[$r['username']],"follow")  )
        {   
            // echo $r['username'],"<br>";
            $sql="insert into Follower (Follower,Followee) values ( '$_GET[follower]','$r[username]')";
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
