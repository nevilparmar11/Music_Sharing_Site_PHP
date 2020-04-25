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
    <title>All Songs</title>
    
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
            <a class="navbar-brand span-visitor"  href="/home/index.html">CTK music</a>
        </div>

        <!-- Items -->
        <div class="collapse navbar-collapse" id="topNavBar">
            <ul class="nav navbar-nav">
                <li class=""><a class="span-visitor" href="/music/albums.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp; Albums</a></li>
                <li class="active"><a class="span-visitor" href="/music/all_songs.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>&nbsp; Songs</a></li>
                <li>
                    <form class="navbar-form navbar-left" role="search" method="post" action="all_songs.php?username=<?php echo $_GET[username]; ?>">
                            <input name="search_string" value="<?php echo $_POST[search_string]; ?>" class="form-control" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </li>            
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li>
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
<div class="col-sm-8 col-md-7">



<div class="panel panel-default">
    <div class="panel-body">

        <h3>All Songs</h3>

        

        <table class="table">
            <thead>
            <tr>
                <th>Song</th>
                <th>Album</th>
                <th>Audio File</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
            <?php
                try{
                    $query=$dbhandler->query("SELECT * FROM Songs NATURAL JOIN Users WHERE  album_title LIKE '%$_POST[search_string]%' OR
                                                                                            song_title LIKE '%$_POST[search_string]%' ");
                    $flag=0;
                    while($r=$query->fetch(PDO::FETCH_ASSOC))
                    {
                        if ( $r['username'] == $_GET['username'] )
                        {
                            $flag=1;
                            echo "<tr>";
                            echo "<td>", $r['song_title'],"<br></td>";
                            echo "<td>", $r['album_title'],"<br></td>"; 
                            echo "<td><audio controls>
                                        <source src='/music/uploads/$r[audio_file]' type='audio/mpeg'>",".mp3</audio><br></td>";
                            
                        }  
                    }
                    if ($flag==0)
                    {
                        echo "<div class='col-sm-2' style='font-size: 15px'>";
                        echo "<tr><td colspan=3>No Songs Found</td></tr></div>";
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