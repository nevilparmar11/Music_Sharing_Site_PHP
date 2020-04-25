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
    <title>Edit Profile</title>
    
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
        <form method="post" action="/users/update_profile.php">
        <table  class="table">
            <thead>
            <tr>
                <th>
                <h3>
                    Edit <?php
                        echo $_SESSION['username'],"'s Profile";
                    ?>
                </h3>
                <a href="/users/my_profile.php">Back to Profile</a>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan=2>
                <?php
                    $msg=$_GET['msg'];
                    try{                        
                        $query=$dbhandler->query("select * from Users WHERE username='$_SESSION[username]'");
                        $r=$query->fetch(PDO::FETCH_ASSOC);
                        
                        echo "<tr>";
                        echo "<td colspan=2><b>First Name:</b> &emsp;<input required type='text' name='First_name' value='",$r[First_name],"'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>Last Name:</b>  &emsp;<input required type='text' name='Last_name' value='",$r[Last_name],"'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>E-mail:</b> &emsp;<input required type='text' name='email' value='",$r[email],"'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>New Password:</b> &emsp;<input required type='password' name='Password'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2><b>Confirm Password:</b> &emsp;<input required type='password' name='conPassword'><br><font color='red'>",$msg,"</font></td>";
                        echo "</tr>";
                        
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        die();
                    }
                ?>
                </td>
                <td>
                    <input class="btn btn-primary" type="submit" name="update_profile" value="Update profile">
                </td>
            </tr>
            
            </tbody>
        </table>
        </form>
    </div>
</div>

</div>
</body>
</html>