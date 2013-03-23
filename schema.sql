CREATE TABLE users
(
username varchar(25) PRIMARY KEY,
password varchar(128) NOT NULL,
name varchar(50) NOT NULL,
email varchar(100) NOT NULL
);

CREATE TABLE privacy
(
type varchar(10) PRIMARY KEY CHECK(type='Public' OR type='Private')
);

CREATE TABLE albums
(
username varchar(25) References users(username) ON DELETE CASCADE,
albumName varchar(100) NOT NULL,
privacy varchar(10) NOT NULL References privacy(type),
totalImages int Default 0,
PRIMARY KEY (username,albumName)
);

CREATE TABLE tags
(
type varchar(15) PRIMARY KEY
);

CREATE TABLE images
(
username varchar(25) References users(username) ON DELETE CASCADE,
albumName varchar(100) NOT NULL References album(albumName) ON DELETE CASCADE ON UPDATE CASCADE,
privacy varchar(10) NOT NULL References privacy(type),
imageName varchar(50) NOT NULL,
tag varchar(15) REFERENCES tags(type),
PRIMARY KEY (username,albumName,imageName)
);