#!/bin/bash

# The priority is a simple upload/download functionality, while maintaining security.
# The idea of this file transfer application is K.I.S.S.
# Keep
# It
# Simple
# Stupid

# Check if root; if not, exit.
current_uid=$(id -u)

function check_root() {
        if [[ ! $current_uid = 0 ]];
        then
                echo "Must run as root.";
                exit -1;
        fi
}

check_root

unzip /var/www/harambo.zip -d /var/www/

# Create backup of /etc/apache2/apache2.conf, then copy secure app conf to same location. 
echo "Backing up /etc/apache2/apache2.conf. File at /etc/apache2/apache2.conf.bak_1"; echo
cp /etc/apache2/apache2.conf /etc/apache2/apache2.conf.bak_1
mv /var/www/html/apache2.conf /etc/apache2/apache2.conf

# Move config.php file to /var/www.
echo "config file at /var/www/html/config.php"; echo
mv /var/www/html/config.php /var/www/config.php

echo "Moving updated dir.conf to /etc/apache2/mods-available/dir.conf. Backing up at /etc/apache2/mods-available/dir.conf.bak_1"; echo
cp /etc/apache2/mods-available/dir.conf /etc/apache2/mods-available/dir.conf.bak_1
mv /var/www/html/dir.conf /etc/apache2/mods-available/dir.conf

# Change permissions of relevant files and directories to www-data.
chown -R www-data:www-data /var/www/html/
chown www-data:www-data /var/www/config.php
chmod 600 /var/www/config.php

# Create database,table, and least privileged user needed for authentication mechanism.
echo "Creating MySQL database \"db1\"."; echo
echo "Creating a MySQL service user called \"www-data\""; echo
mysql -u'root' -h localhost -e \
'CREATE DATABASE db1; USE db1; CREATE TABLE member (userid int(11) NOT null auto_increment, user VARCHAR(256) NOT null, pwd VARCHAR(256) NOT null, PRIMARY key (userid)); CREATE USER "www-data"@"localhost" IDENTIFIED BY "shmeegol_shmorf"; GRANT SELECT ON db1.* TO "www-data"@"localhost"; FLUSH PRIVILEGES; INSERT INTO member VALUES (1, "tester", "$2y$10$.6lMmXtQwyo3qzN1DNdp0OOQpOqv0w9gdAm2BYSqeZIJcMGXp7ajG");'
echo "Make sure to add the password you entered for www-data into the config.php file located at /var/www/"; echo
exit 0
