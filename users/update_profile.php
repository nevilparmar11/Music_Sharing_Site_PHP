<?php
session_start();
if( !isset($_SESSION['username']) )
    header("Location:/users/login.php");

if ( $_POST[Password] != $_POST[conPassword] )
    header("Location:/users/edit_profile.php?msg=Password do not match");
else
{
    try
    {
        $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
        $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        $query1=$dbhandler->query('select * from Users');
        while($r=$query1->fetch(PDO::FETCH_ASSOC))
        {
            if ( $r['username']==$_SESSION['username']  )
            {   
                $sql="  UPDATE Users 
                        SET First_name='$_POST[First_name]', Last_name='$_POST[Last_name]', email='$_POST[email]', password='$_POST[Password]'
                        WHERE username='$_SESSION[username]' ";
                $query=$dbhandler->query($sql);
            } 
        }
        header("Location:/music/albums.php?username=$_SESSION[username]");    
    }
    catch(PDOException $e){
        echo $e->getMessage();
        die();
    }
}
?>