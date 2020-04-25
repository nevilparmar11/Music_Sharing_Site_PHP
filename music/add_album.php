<?php
    session_start();
    if ( !isset($_SESSION[username]) )
        header("Location:/users/login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a New Album</title>
    
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
                <li class="active"><a class="span-visitor"  href="/music/albums.php?username=<?php echo $_SESSION['username']?>"><span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp; Albums</a></li>
                <li class=""><a class="span-visitor" href="/music/all_songs.php?username=<?php echo $_SESSION['username']?>"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>&nbsp; Songs</a></li>
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
<div class="container-fluid">

    <div class="row">

        <div class="col-sm-12 col-md-7">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Add a New Album</h3>
                    
                    <form class="form-horizontal" role="form" action="create_album.php?username=<?php echo $_GET['username'] ?>" method="post" enctype="multipart/form-data">
                        
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <span class="text-danger small"></span>
        </div>
        <label class="control-label col-sm-2" for="song_title"><label for="id_artist">Artist:</label></label>
        <div class="col-sm-10"><input type="text" name="artist" maxlength="250" required id="id_artist"></div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <span class="text-danger small"></span>
        </div>
        <label class="control-label col-sm-2" for="song_title"><label for="id_album_title">Album title:</label></label>
        <div class="col-sm-10"><input type="text" name="album_title" maxlength="500" required id="id_album_title"></div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <span class="text-danger small"></span>
        </div>
        <label class="control-label col-sm-2" for="song_title"><label for="id_genre">Genre:</label></label>
        <div class="col-sm-10"><input type="text" name="genre" maxlength="100" required id="id_genre"></div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <span class="text-danger small"></span>
        </div>
        <label class="control-label col-sm-2"><label for="id_genre">Album logo:</label></label>
        <div class="col-sm-10"><input type="file" name="logo" maxlength="100" required id="id_logo"></div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <span class="text-danger small"></span>
        </div>
        <label class="control-label col-sm-2" for="song_title"><label for="id_genre">Private:</label></label>
        <div class="col-sm-10"><input type="checkbox" name="is_private" id="is_private"></div>
    </div>
    

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div>

</div>

</body>
</html>
