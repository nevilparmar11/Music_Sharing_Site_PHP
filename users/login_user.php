<?php
session_start();
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');

    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	// $sql="create table Users ( 
    //     username VARCHAR(30) NOT NULL PRIMARY KEY,
    //     password VARCHAR(30) NOT NULL,
    //     email VARCHAR(30) NOT NULL
    //     )";
	// $query=$dbhandler->query($sql);
    // echo "Table is created successfully";
    
    
    $query=$dbhandler->query("select * from Users where username='$_POST[username]' and password='$_POST[password]' ");
    $r=$query->fetchAll(PDO::FETCH_ASSOC);
    if( $query->rowCount() == 0)
    {
        header('Location:/users/login.php?valid=invalid');
    }
    else
    {
        $_SESSION['username'] = $_POST['username'];
        header("Location:/music/albums.php?username=$_POST[username]");
    }
}
catch(PDOException $e){
	echo $e->getMessage();
	die();
}

?>

