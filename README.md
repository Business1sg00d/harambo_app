Created and tested on Ubuntu 20.04.6 LTS Focal.

K.I.S.S
```
Keep
It
Simple
Stupid
```

A simple file transfer and download application. Built with security in mind. Less functionality, smaller attack surface, more secure. Slap SSL on it and you'll be good to go.

Tested for the following:
1. SQLi; both manual testing and with sqlmap up to level/risk 3.
2. LFI and Path Traversal.
3. XSS.
4. HTTP Verb Tampering.
5. PHP Wrappers and Filters.
6. OS commands through PHP webshell; get Permission Denied page code 403. Attempted to write /tmp/test.txt with no luck.
7. No IDOR since everyone can access the same pool of files.
8. Not using JSON or XML, so no XXE.
9. No CGIs.

MySQL is running as an unprivileged user with only SELECT rights on the database "db1". The setup.sh file will move config.php into /var/www, outside the webroot with 600 permissions for www-data. This contains the MySQL database information such as user, password, db name, and host. 

The functionality is pretty simple. The login mechanism is simple. No registration function == Less functionality == Smaller attack surface == Happy cybersecurity practitioner

Right!?

------
Install
----------

**The install assumes mysql is running on the default TCP port 3306. It's recommended to run setup.sh as root.**

If spinning up a container or new VM, you'll need the following:
```
apt-get install apache2 mysql-server php libapache2-mod-php zip unzip
```

Move the zip file and setup.sh to /var/www then execute setup.sh
```
./setup.sh
```

"setup.sh" will make the following changes to the file system:
1. Backup apache2.conf to /etc/apache2/apache2.conf.bak_1
2. Backup dir.conf to /etc/apache2/mods-available/dir.conf.bak_1
3. Move config.php to /var/www/config.php
4. Back up the original html/ directory

---------------
Configuration
-----------------------

Adding the following PHP functions to your php.ini files "disable_functions" array will prevent the process from executing them, minimizing access to Operating System commands:
```
system
popen
passthru
exec
shell_exec
```

**Want to change the default user password? You should. (tester:password123)**

1. Do it manually using php:
```
└─$ php -a
Interactive shell

php > $plain_password = "mySecretPassword";

php > $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

php > echo $hashed_password;
```

2. Clear the php command line history:
```
 cp /dev/null ~/.php_history
```

3. Copy the output of the above, and update it into the mysql table 'member':
```
mysql> UPDATE member SET pwd="hashed_pass_from_php" WHERE userid=1;
```

4. Change the user name as well with:
```
mysql> UPDATE member SET user="new_username" WHERE userid=1;
```

**Want to run it with HTTPS?**

1. Run the following command to generate certificate and key:
```
openssl req -x509 -nodes -days 365 -newkey rsa:4096 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt
```

2. Enable SSL for apache:
```
a2enmod ssl
```

3. Ensure /var/run/apache2/ exists with www-data as the owner:
```
chown www-data: /var/run/apache2
```

4. Add the following lines to /etc/apache2/apache2.conf (Change the IP address shown to the one for the server):
```
<VirtualHost *:443>
        DocumentRoot /var/www/html
        SSLEngine on
        SSLCertificateFile /etc/ssl/certs/apache-selfsigned.crt
        SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key

        SSLUseStapling on

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

SSLStaplingCache "shmcb:/var/run/apache2/ssl_stapling(32768)"
ErrorLog ${APACHE_LOG_DIR}/error.log

<VirtualHost *:80>
        Redirect permanent / https://10.0.0.2
</VirtualHost>
```

5. Restart the server:
```
systemctl restart apache2.service
```
