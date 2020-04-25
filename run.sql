
-- create users table
create table Users ( 
    First_name VARCHAR(30) NOT NULL ,
    Last_name VARCHAR(30) NOT NULL ,
    username VARCHAR(30) NOT NULL PRIMARY KEY,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL
    );

-- create albums table
create table Albums (
    imageType VARCHAR(25),
    image MEDIUMBLOB,
    username VARCHAR(30),
    artist VARCHAR(230),
    album_title VARCHAR(250) NOT NULL PRIMARY KEY,
    genre VARCHAR(100),
    is_private TINYINT(1) DEFAULT 0 ,
    FOREIGN KEY (username) REFERENCES Users(username)
    );

-- create songs table
create table Songs (
    audio_file VARCHAR(200),
    album_title VARCHAR(250),
    song_title VARCHAR(230),
    FOREIGN KEY (album_title) REFERENCES Albums(album_title)
    );

-- create shared_albums table
create table Shared_Albums ( 
    Owner VARCHAR(30),
    Reciever VARCHAR(30),
    album_title VARCHAR(250),
    FOREIGN KEY (album_title) REFERENCES Albums(album_title),
    FOREIGN KEY (Reciever) REFERENCES Users(username),
    FOREIGN KEY (Owner) REFERENCES Users(username)
    );

-- create follower table
CREATE TABLE Follower ( 
    follower VARCHAR(200) NOT NULL ,
    followee VARCHAR(200) NOT NULL ,
    created_at TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (follower) REFERENCES Users(username),
    FOREIGN KEY (followee) REFERENCES Users(username)
    );