CREATE TABLE users
(
email varchar(50) PRIMARY KEY,
password varchar(32) NOT NULL,
name varchar(50) NOT NULL
);

CREATE TABLE privacy
(
type varchar(10) PRIMARY KEY CHECK(type='Public' OR type='Private' OR type='Shared')
);

CREATE TABLE albums   /*represents the album created by the as user*/
(
user_created varchar(50) NOT NULL,
albumName varchar(100) NOT NULL,
privacy varchar(10) NOT NULL,
date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
albumId varchar(32) NOT NULL,
PRIMARY KEY (albumId), /*album ID will be a MD5 hash of albumName and user_created*/
INDEX (user_created),
INDEX (privacy),
FOREIGN KEY(user_created) References users(email) ON DELETE CASCADE,
FOREIGN KEY(privacy) References privacy(type)
);

CREATE TABLE shared_albums
(
albumId varchar(32) NOT NULL,
shared_with_userId varchar(50) NOT NULL,
dateOfSharing TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (albumId,shared_with_userId),
INDEX (shared_with_userId),
INDEX (albumId),
FOREIGN KEY(shared_with_userId) References users(email) ON DELETE CASCADE,
FOREIGN KEY(albumId) References albums(albumId) ON DELETE CASCADE
);

CREATE TABLE collaborated_albums
(
albumId varchar(32) NOT NULL,
collaborated_with_userId varchar(50) NOT NULL,
PRIMARY KEY (albumId,collaborated_with_userId),
INDEX (collaborated_with_userId),
INDEX (albumId),
FOREIGN KEY(collaborated_with_userId) References users(email) ON DELETE CASCADE,
FOREIGN KEY(albumId) References albums(albumId) ON DELETE CASCADE
);

CREATE TABLE tags
(
type varchar(15) PRIMARY KEY
);

CREATE TABLE images
(
owner_userId varchar(50) NOT NULL, /*during collaboartion, images might be owned by different users*/
albumId varchar(32) NOT NULL,
privacy varchar(10) NOT NULL,
imageName varchar(50) NOT NULL,
tag varchar(15) REFERENCES tags(type),
imageId varchar(32) NOT NULL, /*imageId will be a MD5 hash of userId, imageName and albumId*/
PRIMARY KEY (imageId),
INDEX (owner_userId),
INDEX (albumId),
INDEX (privacy),
FOREIGN KEY(owner_userId) References users(email) ON DELETE CASCADE,
FOREIGN KEY(albumId) References albums(albumId) ON DELETE CASCADE,
FOREIGN KEY(privacy) References privacy(type)
);

CREATE TABLE metadata
(
imageId varchar(32) PRIMARY KEY,
albumId varchar(32) NOT NULL,
GPS_Latitude float,
GPS_Longitude float,
DateTimeTaken datetime,
ExposureTime float,
FNumber float,
ISOSpeedRatings int,
CompressedBitsPerPixel float,
ShutterSpeedValue float,
ApertureValue float,
FocalLength float,
INDEX(imageId),
INDEX(albumId),
INDEX(DateTimeTaken), /*for quick retrieval*/
FOREIGN KEY(albumId) References albums(albumId) ON DELETE CASCADE,
FOREIGN KEY(imageId) References images(imageId) ON DELETE CASCADE
);

/*Index have been added as they are required for foreign key constraints in a MYSQL database.*/