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
    <title>Follower</title>
    
    <link rel="shortcut icon" type="image/png" href="/static/favicon.ico"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/static/music/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="/static/music/js/main.js"></script>

    <style>
        body {
          background-image: url("images/background.jpg");
          background-size: cover;
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
                <li class=""><a class="span-visitor" href="/music/albums.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp; Albums</a></li>
                <li class=""><a class="span-visitor" href="/music/all_songs.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>&nbsp; Songs</a></li>
               
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a class="span-visitor" href="/users/follow_user.php?username=<?php echo $_SESSION['username'] ?>">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp; Follow Users
                    </a>
                </li>
                <li>
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
                    <h3>Followers</h3>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                <ul>
                <?php
                    try{                        
                        $query=$dbhandler->query("(select follower from Follower WHERE followee='$_SESSION[username]') ");
                        echo "<form action='/users/add_follow_users.php?follower=$_GET[username]' method='post'>";
                        $rows=0;
                        while($r=$query->fetch(PDO::FETCH_ASSOC))
                        {
                            {
                                $rows=1;
                                echo "<tr>";
                                echo "<td><li>". $r['follower'] . " <a href='/users/follower_profile.php?follower=$r[follower]'>View Profile</a></li><br></td>";
                                echo "</tr>";
                            }
                        }
                        if ($rows==0)
                            echo "<tr><td>No Users found</td></tr></form>";
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
</body>
</html>