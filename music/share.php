<?php
if( ($_GET['owner'])=="" )
    header("Location:/users/login.php");
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');

    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	// $sql="create table Shared_Albums ( 
    //     Owner VARCHAR(30),
    //     Reciever VARCHAR(30),
    //     album_title VARCHAR(250)
    //     )";
	// $query=$dbhandler->query($sql);
    // echo "Table is created successfully";

    $query1=$dbhandler->query('select * from Users');
    while($r=$query1->fetch(PDO::FETCH_ASSOC))
    {
        if ( !strcmp($_POST[$r['username']],"share")  )
        {   
            // echo $_GET['owner']," ",$r['username']," ",$_GET['album'],"<br>";
            $sql="insert into Shared_Albums (Owner,Reciever,album_title) values ( '$_GET[owner]','$r[username]','$_GET[album]')";
            $query=$dbhandler->query($sql);
        } 
    }
    header("Location:/music/all_users.php?username=$_GET[owner]&album=$_GET[album]");    
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}

?>
