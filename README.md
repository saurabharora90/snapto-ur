snapto-ur
=========

An image sharing website as a part of the CS3882 Breakthrough Ideas module at NUS.

The website is hosted on Windows Azure. It makes use of a MYSQL database to store user, album and file information.

All uploaded files are stored on the Windows Azure Blob Storage using the Azure SDK for PHP (https://github.com/WindowsAzure/azure-sdk-for-php)


For the Virtual machine branch:

1) Install a Linux OS
2) Update the OS using sudo apt-get upgrade
3) Install LAMP stack: sudo apt-get install apache2 mysql-server php5 php5-mysql libapache2-mod-auth-mysql libapache2-mod-php5 php5-xsl php5-gd php-pear
4) Install phpmyadmin
5) Enable module rewrite: a2enmod rewrite
6) Allow read on .htaccess: /etc/apache2/sites-enabled/000-default
7) restart apache2: service apache2 restart
