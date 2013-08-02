snapto-ur
=========

An image sharing website as a part of the CS3882 Breakthrough Ideas module at NUS.

The main idea is to intelligently scan through the images uploaded by the user to album and present to the user a subset of images which gives a best overview of all the images in the album. It should cover all the important events displayed in the photos and ideally should span across the entire timeframe and location of the album. This will help to reduce the photo spam in this digital age. 

The website is hosted on Windows Azure. It makes use of a MYSQL database to store user, album and file information.

All uploaded files are stored on the Windows Azure Blob Storage using the Azure SDK for PHP (https://github.com/WindowsAzure/azure-sdk-for-php)
