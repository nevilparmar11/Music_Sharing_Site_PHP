<?php
session_start();
if( !isset($_SESSION['username']) )
    header("Location:/users/login.php");
try{
	$dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');

    $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	// $sql="create table Albums ( 
    //     username VARCHAR(30),
    //     artist VARCHAR(230),
    //     album_title VARCHAR(250),
    //     genre VARCHAR(100),
    //     is_favorite BOOLEAN,
    //     FOREIGN KEY (username) REFERENCES Users(username)
    //     )";
	// $query=$dbhandler->query($sql);
    // echo "Table is created successfully";
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
    <title>Albums</title>
    
    <link rel="shortcut icon" type="image/png" href="/static/favicon.ico"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    <link href = "https://fonts.googleapis.com/icon?family=Material+Icons" rel = "stylesheet">
    <link rel="stylesheet" type="text/css" href="/static/music/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="/static/music/js/main.js"></script>

    <style>
        body {
          background-image: url("images/background.jpg");
          background-size: contain;
        }
        .material-icons{
            display: inline-flex;
            vertical-align: bottom;
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
                <li class="active"><a class="span-visitor" href="/music/albums.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp; Albums</a></li>
                <li class=""><a class="span-visitor" href="/music/all_songs.php?username=<?php echo $_GET['username']?>"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>&nbsp; Songs</a></li>
                <li>
                    <form class="navbar-form navbar-left" role="search" method="post" action="/music/albums.php?username=<?php echo $_GET[username]; ?>">
                        <div class="form-group">
                            <input type="search" class="form-control" name="search_text" placeholder="Search" aria-label="Search" value="<?php echo $_POST[search_text]; ?>">
                        </div>
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
<div class="albums-container container-fluid">

    <!-- Albums -->
    <div class="row">
        <div class="col-sm-12">
            <h3><?php 
                    if ( isset($_SESSION['username']) )    
                        echo $_SESSION['username']; 
                    else
                        header("Location:/users/login.php");
                ?>'s Albums</h3>
        </div>
    
        <!-- Fetch albums -->
        <?php

            try{
                $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
            
                $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $query=$dbhandler->query("SELECT * FROM Albums WHERE album_title LIKE '%$_POST[search_text]%' OR
                                                                     artist LIKE '%$_POST[search_text]%' OR 
                                                                     genre LIKE '%$_POST[search_text]%' ");
                
                $flag=0;
                while($r=$query->fetch(PDO::FETCH_ASSOC))
                {
                    if ( $r['username'] == $_GET['username'] )
                    {
                        $flag=1;
                        echo "<div class='col-sm-2' style='font-size: 10px'>";
                        if ( $r[is_private]==1 )
                            echo "<pre><a style='text-decoration:none' href='/music/change_type.php?username=$_GET[username]&album=$r[album_title]'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='Private' data-placement='top' >lock</i></a><br><br>";
                        else if ( $r[is_private]==0 )
                            echo "<pre><a style='text-decoration:none' href='/music/change_type.php?username=$_GET[username]&album=$r[album_title]'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='Public' data-placement='top' >group</i></a><br><br>";
                        
                        if ($r[imageType]=="image/jpeg")
                            echo '<img width=170 src="data:image/jpeg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/jpg")
                            echo '<img width=170 src="data:image/jpg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/png")
                            echo '<img width=170 src="data:image/png;base64,'.base64_encode( $r['image'] ).'"/>';
                        
                        echo "<h3>",$r['album_title'],"</h3>",$r['artist'],"<br>",$r['genre'],"<br><br>",
                        "<a style='text-decoration:none' href='/music/songs.php?username=",$_GET['username'],"&album=",$r['album_title'],"'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='View Album' data-placement='top'>remove_red_eye</i></a>",
                        "<a style='text-decoration:none' href='/music/delete_album.php?username=",$_GET['username'],"&album=",$r['album_title'],"'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='Delete Album' data-placement='top'>delete</i></a>",
                        "<a style='text-decoration:none' href='/music/all_users.php?username=",$_GET['username'],"&album=",$r['album_title'],"'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='Share Album' data-placement='top'>share</i></a>",
                        "</pre>"; 
                        echo "</div>";
                    }
                }
                if ($flag==0)
                {
                    echo "<div class='col-sm-2' style='font-size: 15px'>";
                    echo "No Albums Found</div>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
                die();
            }

        ?>

        <div class="col-sm-12">
            <br>
            <a href="/music/add_album.php?username=<?php echo $_GET['username'] ?>">
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp; Add an Album
                </button>
            </a>
        </div>
        
    </div>
    <hr>
    <!--Received albums which are private -->

    <div class="row">
        <div class="col-sm-12">
            <h3>Received Albums</h3>
        </div>
        <?php

            try{
                $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
            
                $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $query=$dbhandler->query("select * from Albums natural join Shared_Albums WHERE album_title LIKE '%$_POST[search_text]%' OR
                                                                                                artist LIKE '%$_POST[search_text]%' OR 
                                                                                                genre LIKE '%$_POST[search_text]%' ");
                $flag=0;
                while($r=$query->fetch(PDO::FETCH_ASSOC))
                {
                    if ( $r['Reciever'] == $_GET['username'] && $r[is_private]==1 )
                    {
                        $flag=1;
                        echo "<div class='col-sm-2' style='font-size: 10px'>";
                        echo "<pre>";
                        if ($r[imageType]=="image/jpeg")
                            echo '<img width=170  src="data:image/jpeg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/jpg")
                            echo '<img width=170  src="data:image/jpg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/png")
                            echo '<img width=170  src="data:image/png;base64,'.base64_encode( $r['image'] ).'"/>';
                        
                        
                        echo "<h3>",$r['album_title'],"</h3>",$r['artist'],"<br>",$r['genre'],"<br><br>",
                        "<a style='text-decoration:none' href='/music/songs.php?username=",$_GET['username'],"&reciever=",$r['Reciever'],"&album=",$r['album_title'],"'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='View Album' data-placement='top'>remove_red_eye</i></a></h4>",
                        "<a style='text-decoration:none' href='/music/delete_shared_album.php?username=",$_GET['username'],"&reciever=",$r['Reciever'],"&album=",$r['album_title'],"'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='Remove Album' data-placement='top'>delete</i> </a></h4>",
                        "<h4>Shared by: $r[Owner]</h4>",
                        "</pre>"; 
                        echo "</div>";
                    }
                   
                }
                if ($flag==0)
                {
                    echo "<div class='col-sm-2' style='font-size: 15px'>";
                    echo "No Albums Found</div>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
                die();
            }

        ?>
        
        
    </div>
    <hr>

    <!--Friend's albums-->
    <div class="row">
        <div class="col-sm-12">
            <h3>Friend's Albums</h3>
        </div>
        <?php

            try{
                $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
            
                $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $query=$dbhandler->query("SELECT followee FROM Follower WHERE follower='$_GET[username]'");

                $flag=0;
                while($r=$query->fetch(PDO::FETCH_ASSOC))
                {
                    $followee = $r[followee];
                    $query1=$dbhandler->query("SELECT * FROM Albums WHERE album_title LIKE '%$_POST[search_text]%' OR
                                                                          artist LIKE '%$_POST[search_text]%' OR 
                                                                          genre LIKE '%$_POST[search_text]%' ");
                    while($r1=$query1->fetch(PDO::FETCH_ASSOC))
                    {
                        if( $followee==$r1[username] )
                        {
                            $flag=1;

                            echo "<div class='col-sm-2' style='font-size: 10px'>";
                            echo "<pre>";
                            if ($r1[imageType]=="image/jpeg")
                                echo '<img width=170 src="data:image/jpeg;base64,'.base64_encode( $r1['image'] ).'"/>';
                            else if ($r1[imageType]=="image/jpg")
                                echo '<img width=170 src="data:image/jpg;base64,'.base64_encode( $r1['image'] ).'"/>';
                            else if ($r1[imageType]=="image/png")
                                echo '<img width=170 src="data:image/png;base64,'.base64_encode( $r1['image'] ).'"/>';
                        
                        
                            echo "<h3>",$r1['album_title'],"</h3>",$r1['artist'],"<br>",$r1['genre'],"<br><br>",
                            "<a style='text-decoration:none' href='/music/songs.php?username=",$_GET['username'],"&album=",$r1['album_title'],"&is_public=yes'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='View Album' data-placement='top'>remove_red_eye</i></a>",
                            "<h4>Owner: ",$followee,"</h4>",
                            "</pre>"; 
                            echo "</div>";
                        }
                    }
                }
                if ($flag==0)
                {
                    echo "<div class='col-sm-2' style='font-size: 15px'>";
                    echo "No Albums Found</div>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
                die();
            }

        ?>
        
        
    </div> 
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h3>Public Albums</h3>
        </div>
    
        <!--Other Public Albums -->
        <?php

            try{
                $dbhandler = new PDO('mysql:host=127.0.0.1;dbname=phpmyadmin','phpmyadmin','pkp010900');
            
                $dbhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $query=$dbhandler->query("SELECT * FROM Albums WHERE album_title LIKE '%$_POST[search_text]%' OR
                                                                     artist LIKE '%$_POST[search_text]%' OR 
                                                                     genre LIKE '%$_POST[search_text]%' ");
                $flag=0;
                while($r=$query->fetch(PDO::FETCH_ASSOC))
                {
                    if ( $r['is_private'] == 0 && $r['username']!=$_SESSION['username'] )
                    {
                        $flag=1;
                        echo "<div class='col-sm-2' style='font-size: 10px'>";
                        echo "<pre>";
                        if ($r[imageType]=="image/jpeg")
                            echo '<img width=170 src="data:image/jpeg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/jpg")
                            echo '<img width=170 src="data:image/jpg;base64,'.base64_encode( $r['image'] ).'"/>';
                        else if ($r[imageType]=="image/png")
                            echo '<img width=170 src="data:image/png;base64,'.base64_encode( $r['image'] ).'"/>';
                        
                        
                        echo "<h3>",$r['album_title'],"</h3>",$r['artist'],"<br>",$r['genre'],"<br><br>",
                        "<a style='text-decoration:none' href='/music/songs.php?username=",$_GET['username'],"&album=",$r['album_title'],"&is_public=yes'><i class = 'material-icons btn btn-default' data-toggle='tool-tip' title='View Album' data-placement='top'>remove_red_eye</i></a>",
                        "<h4>Owner: $r[username] </h4>",
                        "</pre>"; 
                        echo "</div>";
                    }
                }
                if ($flag==0)
                {
                    echo "<div class='col-sm-2' style='font-size: 15px'>";
                    echo "No Albums Found</div>";
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
                die();
            }

        ?>
    </div>
    <hr>
    
</div>

</body>
</html>


