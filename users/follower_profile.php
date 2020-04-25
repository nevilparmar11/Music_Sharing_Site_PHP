<?php
session_start();
if( !isset($_SESSION['username']) )
    header("Location:/users/login.php");
try{
    $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    
    <link rel="shortcut icon" type="image/png" href="/static/favicon.ico"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/static/music/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="/static/music/js/main.js"></script>

    <style>
        body 
        {
          background-image: url("images/background.jpg");
          background-size: contain;
        }

        .navbar-brand{
            font-family: 'Satisfy', cursive;
        }
        .span-visitor{
            font-size: 17px;
            color: white;
        }
        .header-blue{
            background-color: #08192d;
        }
    </style>
</head>
<body>
<header class="header-section clearfix header-blue">

    <div class="container-fluid">

        <!-- Header -->
        <div class="navbar-header">
            <a class="navbar-brand span-visitor" href="/home/index.html">CTK music</a>
        </div>

        <!-- Items -->
        <div class="collapse navbar-collapse" id="topNavBar">
            <ul class="nav navbar-nav">
                <li class=""><a class="span-visitor" href="/music/albums.php?username=<?php echo $_SESSION['username']?>"><span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp; Albums</a></li>
                <li class=""><a class="span-visitor" href="/music/all_songs.php?username=<?php echo $_SESSION['username']?>"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>&nbsp; Songs</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="span-visitor" href="/users/follow_user.php?username=<?php echo $_SESSION['username'] ?>">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp; Follow Users
                    </a>
                </li>
                <li class="active">
                    <a class="span-visitor" href="/users/my_profile.php?username=<?php echo $_SESSION['username'] ?>">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp; My Profile
                    </a>
                </li>
                <li>
                    <a class="span-visitor" href="/users/logout.php">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp; Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
    </header>
<br>
<div class="col-sm-6 col-md-5">

<div class="panel panel-default">
    <div class="panel-body">

        <table  class="table">
            <thead>
            <tr>
                <th>
                <h3>
                    <?php
                        echo $_GET['follower'],"'s Profile";
                    ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan=2>
                <?php
                    try{                        
                        $query=$dbhandler->query("select * from Users WHERE username='$_GET[follower]'");
                        $r=$query->fetch(PDO::FETCH_ASSOC);

                        echo "<tr>";
                        echo "<td colspan=2><b>First Name:</b> ", $r[First_name]  ,"</br></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>Last Name:</b> ", $r[Last_name]  ,"</br></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>Username:</b> ", $r[username]  ,"</br></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>E-mail:</b> ", $r[email]  ,"</br></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select * from Follower WHERE followee='$_GET[follower]'");
                        $follower=0;
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $follower++;
                        }
                        echo "<tr>";
                        echo "<td colspan=2><b>Followers:</b> ", $follower  ,"</br></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select * from Follower WHERE follower='$_GET[follower]'");
                        $following=0;
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $following++;
                        }
                        echo "<tr>";
                        echo "<td colspan=2><b>Following: </b> ", $following  ,"</br></td>";
                        echo "</tr>";
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                <?php
                    try{                        
                        $query=$dbhandler->query("select * from Albums WHERE username='$_GET[follower]'");
                        
                        $private=0;
                        
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            if ( $r[is_private]==1)
                            {
                                $private++;
                            }
                        }
                        

                        echo "<tr>";
                        echo "<td colspan=2><h4>Private Albums: ", $private  ,"</br><h4></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select * from Albums WHERE username='$_GET[follower]'");
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $count_songs=0;
                            if ( $r[is_private]==1 )
                            {
                                $query1=$dbhandler->query("select * from Songs WHERE album_title='$r[album_title]'");
                                while($r1=$query1->fetch(PDO::FETCH_ASSOC))
                                {
                                    $count_songs++;
                                }
                                echo "<tr>";
                                echo "<td>&emsp;&emsp;", $r[album_title]  ," :- </br><h4></td>";
                                echo "<td>&emsp;&emsp;", $count_songs  ," song(s)</br><h4></td>";
                                echo "</tr>";
                            }
                        }
                        
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td colspan=2> 
                <?php
                    try{                        
                        $query=$dbhandler->query("select * from Albums WHERE username='$_GET[follower]'");
                        
                        $public=0;
                        
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            if ( $r[is_private]==0)
                            {
                                $public++;
                            }
                        }
                        

                        echo "<tr>";
                        echo "<td colspan=2><h4>Public Albums: ", $public  ,"</br><h4></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select * from Albums WHERE username='$_GET[follower]'");
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $count_songs=0;
                            if ( $r[is_private]==0 )
                            {
                                $query1=$dbhandler->query("select * from Songs WHERE album_title='$r[album_title]'");
                                while($r1=$query1->fetch(PDO::FETCH_ASSOC))
                                {
                                    $count_songs++;
                                }
                                echo "<tr>";
                                echo "<td>&emsp;&emsp;", $r[album_title]  ," :- </br><h4></td>";
                                echo "<td>&emsp;&emsp;", $count_songs  ," song(s)</br><h4></td>";
                                echo "</tr>";
                            }
                        }
                        
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td colspan=2> 
                <?php
                    try{                        
                        $query=$dbhandler->query("select DISTINCT album_title from Shared_Albums WHERE Owner='$_GET[follower]'");
                        
                        $shared=0;
                        
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $shared++;
                        }
                        
                        echo "<tr>";
                        echo "<td colspan=2><h4>Shared Albums: ", $shared  ,"</br><h4></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select DISTINCT album_title from Shared_Albums WHERE Owner='$_GET[follower]'");
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $count_songs=0;
                            {
                                $query1=$dbhandler->query("select * from Songs WHERE album_title='$r[album_title]'");
                                while($r1=$query1->fetch(PDO::FETCH_ASSOC))
                                {
                                    $count_songs++;
                                }
                                echo "<tr>";
                                echo "<td>&emsp;&emsp;", $r[album_title]  ," :- </br><h4></td>";
                                echo "<td>&emsp;&emsp;", $count_songs  ," song(s)</br><h4></td>";
                                echo "</tr>";
                            }
                        }
                        
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td colspan=2> 
                <?php
                    try{                        
                        $query=$dbhandler->query("select DISTINCT album_title from Shared_Albums WHERE Reciever='$_GET[follower]'");
                        
                        $recieved=0;
                        
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $recieved++;
                        }
                        
                        echo "<tr>";
                        echo "<td colspan=2><h4>Received Albums: ", $recieved  ,"</br><h4></td>";
                        echo "</tr>";

                        $query=$dbhandler->query("select DISTINCT album_title from Shared_Albums WHERE Reciever='$_GET[follower]'");
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            $count_songs=0;
                            {
                                $query1=$dbhandler->query("select * from Songs WHERE album_title='$r[album_title]'");
                                while($r1=$query1->fetch(PDO::FETCH_ASSOC))
                                {
                                    $count_songs++;
                                }
                                echo "<tr>";
                                echo "<td>&emsp;&emsp;", $r[album_title]  ," :- </br><h4></td>";
                                echo "<td>&emsp;&emsp;", $count_songs  ," song(s)</br><h4></td>";
                                echo "</tr>";
                            }
                        }
                        
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
            </tr>
            
            </tbody>
        </table>
    </div>
</div>

</div>
</body>
</html>